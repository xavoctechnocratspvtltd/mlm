<?php

namespace xavoc\mlm;

class View_PaymentMode extends \xepan\cms\View_Tool{
	public $kit_id = 0;
	public $checkout_page = "payment";

	function init(){
		parent::init();

		if(!$this->kit_id){
			$this->add('View_Warning')->set('kit id not found')->addClass('alert alert-warning');
		}

		$this->kit_model = $kit_model = $this->add('xavoc\mlm\Model_Kit')->load($this->kit_id);

		$this->distributor = $distributor = $this->add('xavoc\mlm\Model_Distributor');
		$distributor->loadLoggedIn();
		if(!$distributor->loaded()){
			return "distributor not found";
		}

		// check address must not be empty
		if(!$distributor['country_id'] OR !$distributor['state_id'] OR !$distributor['address'] OR !$distributor['city'] OR ! $distributor['pin_code']){
			$v = $this->add('View')->addClass('alert alert-warning');
			$v->add('View')->set("please update your country,state, address and profile");
			$v->add('Button')->addClass('btn btn-warning')->set('Go To Setting')->js('click')->univ()->redirect('setting');
			return;
		}

		if($distributor['kit_item_id']){
			$this->add('View_Info')->set('you are updating your topup')->addClass('alert alert-info');
			// if($distributor->isTopupPaymentDue()){
			// 	$this->add('View')->set("your last topup is under verification process, for re-topup cancle order now");
			// 	return;				
			// }else{
			// }
		}


		$this->attachment = $attachment = $this->add('xavoc\mlm\Model_Attachment');
		$attachment->addCondition('distributor_id',$distributor->id);
		$attachment->setOrder('id','desc');
		$attachment->tryLoadAny();

		if($attachment->count()->getOne() > 1){
			$this->add('View')->set('more the two attachment row found, some thing wrong')->addClass('alert alert-danger');
			return ;
		}

		// check kyc address is complete
		if(!$distributor['country_id'] AND !$distributor['state_id'] AND !$distributor['city'] AND $distributor['address']){
			$v = $this->add("View")->addClass('alert alert-danger')->set('first update kyc detai, like addess, city, state and country');
			$this->add('Button')->addClass('btn btn-danger')->set('Go To Setting Page')->js('click')->univ()->redirect($this->app->url('setting'));
			return ;
		}

		$tabs = $this->add('Tabs');
		// $online_tab = $tabs->addTab('Online');
		// $cash_tab = $tabs->addTab('Cash');
		$cheque_tab = $tabs->addTab('Cheque');
		$dd_tab = $tabs->addTab('Demand Draft');
		$df_tab = $tabs->addTab('Deposite in Franchises \ Company');

		// $online_pay_btn = $online_tab->add('Button')->set("pay via online")->addClass('btn btn-primary');
		// if($online_pay_btn->isClicked()){
		// 	$order_id = 0;
		// 	$message = "";
		// 	try{
		// 		$this->app->db->beginTransaction();

		// 		$result = $this->placeOrder($this->kit_id);
		// 		$order_id = $result['order_id'];
		// 		$message = $result['message'];
		// 		$payment_mode = "online";
		// 		$payment_detail = [];

		// 		$distributor->updateTopupHistory($this->kit_id,$result['order_id'],$payment_mode,$payment_detail);

		// 		$this->app->db->commit();
		// 	}catch(\Exception $e){
		// 		$this->app->db->rollback();
		// 		$this->js()->univ()->errorMessage($e->getMessage())->execute();
		// 	}


		// 	if($order_id){
		// 		$url = $this->app->url($this->checkout_page,['order_id'=>$order_id,'step'=>'payment','pay_now'=>true]);
		// 		$js_event = [
		// 			$this->app->js()->univ()->redirect($url),
		// 			$this->app->js()->univ()->closeDialog()
		// 		];
		// 		$this->js(null,$js_event)->univ()->successMessage($message)->execute();
		// 	}else{
		// 		$this->js()->univ()->errorMessage($message." something wrong, server problem")->execute();
		// 	}
			
		// }


		$cheque_form = $cheque_tab->add('Form');
		$cheque_form->addField('bank_name')->validate('required');
		$cheque_form->addField('bank_ifsc_code')->validate('required');
		$cheque_form->addField('cheque_number')->validate('required');
		$cheque_form->addField('DatePicker','cheque_date')->validate('required');
		$cheque_form->addField('DatePicker','deposite_date')->validate('required');
		$cheque_form->addField('text','narration');

		$field = $cheque_form->addField('Upload','cheque_deposite_receipt_image_id');
		$field->setModel('xepan\filestore\Image');
		// $cheque_form->setModel($attachment,['cheque_deposite_receipt_image_id']);
		$cheque_form->addSubmit('Submit')->addClass('btn btn-primary');
		
		if($cheque_form->isSubmitted()){

			if(!$cheque_form['cheque_deposite_receipt_image_id']) $cheque_form->error('cheque_deposite_receipt_image_id','must not be empty');
			if(!$cheque_form['cheque_date']) $cheque_form->error('cheque_date','must not be empty');

			try{
				$this->app->db->beginTransaction();

				$result = $this->placeOrder($kit_model->id);
				if($result['status'] == "failed") throw new \Exception($result['message']);
				
				$payment_mode = "cheque";
				$payment_detail = [
							'office_receipt_image_id' => 0,
							'dd_deposite_receipt_image_id' => 0,
							'cheque_deposite_receipt_image_id' => $cheque_form['cheque_deposite_receipt_image_id'],
							'payment_narration' => $cheque_form['narration'],
							'bank_name' => $cheque_form['bank_name'],
							'bank_ifsc_code' => $cheque_form['bank_ifsc_code'],
							'cheque_number' => $cheque_form['cheque_number'],
							'cheque_date' => $cheque_form['cheque_date'],
							'deposite_date' => $cheque_form['deposite_date']
						];

				$distributor->purchaseKit($kit_model->id);
				$distributor->updateTopupHistory($kit_model->id,$result['order_id'],$payment_mode,$payment_detail);
				
				$this->app->db->commit();
			}catch(\Exception $e){
				$this->app->db->rollback();
				$cheque_form->js()->univ()->errorMessage($e->getMessage())->execute();
			}
			$cheque_form->js(null,$cheque_form->js()->redirect($this->app->url('dashboard')))->univ()->successMessage('Cheque Detail Submitted')->execute();		
		}

		// dd deposite in bank
		$dd_form = $dd_tab->add('Form');
		$dd_form->addField('bank_name')->validate('required');
		$dd_form->addField('bank_ifsc_code')->validate('required');
		$dd_form->addField('dd_number')->validate('required');
		$dd_form->addField('DatePicker','dd_date')->validate('required');
		$dd_form->addField('DatePicker','deposite_date')->validate('required');
		$dd_form->addField('text','narration');

		$field = $dd_form->addField('Upload','dd_deposite_receipt_image_id');
		$field->setModel('xepan\filestore\Image');

		// $dd_form->setModel($attachment,['dd_deposite_receipt_image_id']);
		$dd_form->addSubmit('Submit')->addClass('btn btn-primary');
		if($dd_form->isSubmitted()){

			if(!$dd_form['dd_deposite_receipt_image_id']) $dd_form->error('dd_deposite_receipt_image_id','must not be empty');
			if(!$dd_form['dd_date']) $dd_form->error('dd_date','must not be empty');
			
			try{
				$this->app->db->beginTransaction();

				$result = $this->placeOrder($kit_model->id);
				if($result['status'] == "failed") throw new \Exception($result['message']);
				
				$payment_mode = "dd";
				$payment_detail = [
							'office_receipt_image_id' => 0,
							'dd_deposite_receipt_image_id' => $dd_form['dd_deposite_receipt_image_id'],
							'cheque_deposite_receipt_image_id' => 0,
							'payment_narration' => $dd_form['narration'],
							'bank_name' => $dd_form['bank_name'],
							'bank_ifsc_code' => $dd_form['bank_ifsc_code'],
							'dd_number' => $dd_form['dd_number'],
							'dd_date' => $dd_form['dd_date'],
							'deposite_date' => $dd_form['deposite_date']
						];

				$distributor->purchaseKit($kit_model->id);
				$distributor->updateTopupHistory($kit_model->id,$result['order_id'],$payment_mode,$payment_detail);
				
				$this->app->db->commit();
			}catch(\Exception $e){
				$this->app->db->rollback();
				$dd_form->js()->univ()->errorMessage($e->getMessage())->execute();
			}
			$dd_form->js(null,$dd_form->js()->redirect($this->app->url('dashboard')))->univ()->successMessage('DD Detail Submitted')->execute();
		}

		// deposite in company
		$form = $df_tab->add('Form');
		$field = $form->addField('Upload','office_receipt_image_id');
		$field->setModel('xepan\filestore\Image');

		$form->addField('text','narration');
		$form->addField('checkbox','deposite_in_company')->set(true);
		$form->addSubmit('Submit')->addClass('btn btn-primary');

		if($form->isSubmitted()){
			try{
				$this->app->db->beginTransaction();

				$result = $this->placeOrder($kit_model->id);
				if($result['status'] == "failed") throw new \Exception($result['message']);
				
				// $distributor['deposite_in_office_narration'] = $form['narration'];
				// $distributor['sale_order_id'] = $result['order_id'];
				$payment_mode = $form['deposite_in_company']?'deposite_in_company':'deposite_in_franchies';
				$payment_detail = [
							'office_receipt_image_id' => $form['office_receipt_image_id'],
							'dd_deposite_receipt_image_id' => 0,
							'cheque_deposite_receipt_image_id' => 0,
							'payment_narration' => $form['narration']
						];

				$distributor->purchaseKit($kit_model->id);
				$distributor->updateTopupHistory($kit_model->id,$result['order_id'],$payment_mode,$payment_detail);
				
				$this->app->db->commit();
				}catch(\Exception $e){
					$this->app->db->rollback();
					$form->js()->univ()->errorMessage($e->getMessage())->execute();
				}
						
				$form->js(null,$form->js()->redirect($this->app->url('dashboard')))->univ()->successMessage('Detail Submitted')->execute();
			}
	}
	

	function placeOrder($kit_id){
		
		$updating_kit = false;
		if($this->distributor['kit_item_id']) $updating_kit = true;
				
		$result = ['status'=>'failed','message'=>'some thing went wrong'];

		$kit_model = $this->add('xavoc\mlm\Model_Kit');
		$kit_model->tryLoad($kit_id);
		if(!$kit_model->loaded())
			throw new \Exception("kit not found", 1);
			
		// $distributor = $this->add('xavoc\mlm\Model_Distributor');
		// $distributor->loadLoggedIn();
		$distributor = $this->distributor;
		// return to login page
		if(!$distributor->loaded()){
			return ['status'=>'failed','message'=>'distributor not loaded'];
		}
		
		try{

			//Load Default TNC
			$tnc = $this->add('xepan\commerce\Model_TNC')->addCondition('is_default_for_sale_order',true)->setLimit(1)->tryLoadAny();
			$tnc_id = $tnc->loaded()?$tnc['id']:0;
			$tnc_text = $tnc['content']?$tnc['content']:"not defined";

			$country_id = $distributor['billing_country_id']?:$distributor['country_id']?:0;
			$state_id = $distributor['billing_state_id']?:$distributor['state_id']?:0;
			$city = $distributor['billing_city']?:$distributor['city']?:"not defined";
			$address = $distributor['billing_address']?:$distributor['address']?:"not defined";
			$pincode = $distributor['billing_pincode']?:$distributor['pin_code']?:"not defined";

			$master_detail = [
							'contact_id' => $distributor->id,
							'currency_id' => $distributor['currency_id']?$distributor['currency_id']:$this->app->epan->default_currency->get('id'),
							'nominal_id' => 0,
							'billing_country_id'=> $country_id,
							'billing_state_id'=> $state_id,
							'billing_name'=> $distributor['name'],
							'billing_address'=> $address,
							'billing_city'=> $city,
							'billing_pincode'=> $pincode,
							'shipping_country_id'=> $country_id,
							'shipping_state_id'=> $state_id,
							'shipping_name'=> $distributor['name'],
							'shipping_address'=> $address,
							'shipping_city'=> $city,
							'shipping_pincode'=> $pincode,
							'is_shipping_inclusive_tax'=> 0,
							'is_express_shipping'=> 0,
							'narration'=> null,
							'round_amount'=> 0,
							'discount_amount'=> 0,
							'exchange_rate' => $this->app->epan->default_currency['value'],
							'tnc_id'=>$tnc_id,
							'tnc_text'=> $tnc_text,
							'status' => "OnlineUnpaid",
							'due_date'=>$this->app->nextDate($this->app->now)
						];

			$detail_data = [];


			$tax_array = $kit_model->getTaxAmount($distributor->id);
			$taxation_id = $tax_array['taxation_id'];
			$tax_percentage = $tax_array['tax_percentage'];

			// $taxation = $kit_model->applicableTaxation();
			// if($taxation instanceof \xepan\commerce\Model_Taxation){
			// 	$taxation_id = $taxation->id;
			// 	$tax_percentage = $taxation['percentage'];
			// }else{
			// 	$taxation_id = 0;
			// 	$tax_percentage = 0;
			// }


			$sale_price = $kit_model['sale_price'];
			if($updating_kit){
				$t = $this->add('xavoc\mlm\Model_TopupHistory');
				$t->addCondition('distributor_id',$distributor->id);
				$t->setOrder('id','desc');
				$t->tryLoadAny();
				if($t->loaded()){
					$d1 = strtotime($this->app->today);
					$d2 = strtotime($t['created_at']);

					$diff_secs = abs($d1 - $d2);
		            $base_year = min(date("Y", $d1), date("Y", $d2));
					$diff = mktime(0, 0, $diff_secs, 1, 1, $base_year);
		            $days_diff = date("j", $diff) - 1;
		            $limit = $this->app->getConfig('update_topup_duration',30);
					// 30 > 20
					// 30 > 40
					if($limit > $days_diff){
						$sale_price = $sale_price - $t['sale_price'];
						if($sale_price < 0)
							$sale_price = 0;
					}
				}
			}

			$qty_unit_id = $kit_model['qty_unit_id'];
			$item = [
				'item_id'=>$kit_model->id,
				'price'=>$sale_price,
				'quantity' => 1,
				'taxation_id' => $taxation_id,
				'tax_percentage' => $tax_percentage,
				'narration'=>null,
				'extra_info'=>"{}",
				'shipping_charge'=>0,
				'shipping_duration'=>0,
				'express_shipping_charge'=>0,
				'express_shipping_duration'=>null,
				'qty_unit_id'=>$qty_unit_id,
				'discount'=>0
			];

			$detail_data[] = $item;

			$qsp = $this->add('xepan\commerce\Model_QSP_Master')->createQSP($master_detail,$detail_data,'SalesOrder');

			// afetr payment is complete then kit is associateted with distributor
			// associating kit id with distributor
			// $distributor['kit_item_id'] = $kit_model->id;
			// $distributor->save();

			$result = ['status'=>'success','message'=>'redirect to payment gateway please wait ...','order_id'=>$qsp['master_detail']['id']];

		}catch(\Exception $e){
			$result = ['status'=>'failed','message'=>$e->getMessage()];
		}

		return $result;
	}
}