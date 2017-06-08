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

		$kit_model = $this->add('xavoc\mlm\Model_Kit')->load($this->kit_id);

		$this->distributor = $distributor = $this->add('xavoc\mlm\Model_Distributor');
		$distributor->loadLoggedIn();
		if(!$distributor->loaded()){
			return "distributor not found";
		}

		if($distributor['kit_item_id']){
			$this->add('View_Info')->set('you have a kit or you purchased it');
			return;
		}

		$tabs = $this->add('Tabs');
		$online_tab = $tabs->addTab('Online');
		$cash_tab = $tabs->addTab('Cash');
		$cheque_tab = $tabs->addTab('Cheque');
		$dd_tab = $tabs->addTab('Demand Draft');
		$df_tab = $tabs->addTab('Deposite in Franchies');

		$online_pay_btn = $online_tab->add('Button')->set("pay via online")->addClass('btn btn-primary');
		if($online_pay_btn->isClicked()){
			$result = $this->placeOrder($this->kit_id);

			if($result['status'] == "success"){
				$url = $this->app->url($this->checkout_page,['order_id'=>$result['order_id'],'step'=>'payment','pay_now'=>true]);
				$js_event = [
					$this->app->js()->univ()->redirect($url),
					$this->app->js()->univ()->closeDialog()
				]; 
				return $this->js(null,$js_event)->univ()->successMessage($result['message'])->execute();
			}else{
				return $this->js()->univ()->errorMessage($result['message'])->execute();
			}
		}

		$cash_form = $cash_tab->add('Form');
		$cash_form->addSubmit('Due');
		if($cash_form->isSubmitted()){

			$distributor['payment_mode'] = "cash";
			$distributor->purchaseKit($kit_model);

			$cash_form->js(null,$cash_form->js()->univ()->closeDialog())->univ()->errorMessage('Cash Deposite')->execute();
		}

		$attachment = $this->add('xavoc\mlm\Model_Attachment');
		$attachment->addCondition('distributor_id',$distributor->id);

		$cheque_form = $cheque_tab->add('Form');
		$cheque_form->addField('bank_name')->validate('required');
		$cheque_form->addField('bank_ifsc_code')->validate('required');
		$cheque_form->addField('cheque_number')->validate('required');
		$cheque_form->addField('DatePicker','cheque_date')->validate('required');
		$cheque_form->setModel($attachment,['cheque_deposite_receipt_image_id']);
		$cheque_form->addSubmit('Submit');
		
		if($cheque_form->isSubmitted()){
			$cheque_form->update();

			$distributor['payment_mode'] = "cheque";
			$distributor['kit_id'] = $cheque_form['bank_name'];
			$distributor['bank_name'] = $cheque_form['bank_name'];
			$distributor['bank_ifsc_code'] = $cheque_form['bank_ifsc_code'];
			$distributor['cheque_number'] = $cheque_form['cheque_number'];
			$distributor['cheque_date'] = $cheque_form['cheque_date'];
			$distributor->purchaseKit($kit_model);

			$cheque_form->js(null,$cheque_form->js()->univ()->closeDialog())->univ()->successMessage('cheque detail submitted')->execute();
		}

		$dd_form = $dd_tab->add('Form');
		$dd_form->addField('bank_name');
		$dd_form->addField('bank_ifsc_code');
		$dd_form->addField('dd_number');
		$dd_form->addField('DatePicker','dd_date');
		$dd_form->setModel($attachment,['dd_deposite_receipt_image_id']);
		$dd_form->addSubmit('Submit');
		if($dd_form->isSubmitted()){

			$dd_form->update();

			$distributor['payment_mode'] = "dd";
			$distributor['bank_name'] = $dd_form['bank_name'];
			$distributor['bank_ifsc_code'] = $dd_form['bank_ifsc_code'];
			$distributor['cheque_number'] = $dd_form['cheque_number'];
			$distributor['cheque_date'] = $dd_form['cheque_date'];
			$distributor->purchaseKit($kit_model);

			$dd_form->js(null,$dd->js()->univ()->closeDialog())->univ()->successMessage('DD detail submitted')->execute();
		}

	}

	function placeOrder($kit_id){

		$result = ['status'=>'failed','message'=>'some thing gone wrong'];

		$kit_model = $this->add('xavoc\mlm\Model_Kit');
		$kit_model->tryLoad($kit_id);
		if(!$kit_model->loaded())
			throw new \Exception("kit not found", 1);
			
		$distributor = $this->add('xavoc\mlm\Model_Distributor');
		$distributor->loadLoggedIn();

		// return to login page
		if(!$distributor->loaded()){
			return ['status'=>'failed','message'=>'distributor not loaded'];
		}

		try{

			//Load Default TNC
			$tnc = $this->add('xepan\commerce\Model_TNC')->addCondition('is_default_for_sale_order',true)->setLimit(1)->tryLoadAny();
			$tnc_id = $tnc->loaded()?$tnc['id']:0;
			$tnc_text = $tnc['content']?$tnc['content']:"not defined";

			$master_detail = [
							'contact_id' => $distributor->id,
							'currency_id' => $distributor['currency_id']?$customer['currency_id']:$this->app->epan->default_currency->get('id'),
							'nominal_id' => 0,
							'billing_country_id'=> $distributor['billing_country_id']?:"0",
							'billing_state_id'=> $distributor['billing_state_id']?:"0",
							'billing_name'=> $distributor['billing_name']?:"not defined",
							'billing_address'=> $distributor['billing_address']?:"not defined",
							'billing_city'=> $distributor['billing_city']?:"not defined",
							'billing_pincode'=> $distributor['billing_pincode']?:"not defined",
							'shipping_country_id'=> $distributor['shipping_country_id']?:0,
							'shipping_state_id'=> $distributor['shipping_state_id']?:0,
							'shipping_name'=> $distributor['shipping_name']?:"not defined(name)",
							'shipping_address'=> $distributor['shipping_address']?:"not defined",
							'shipping_city'=> $distributor['shipping_city']?:"not defined",
							'shipping_pincode'=> $distributor['shipping_pincode']?:"not defined",
							'is_shipping_inclusive_tax'=> 0,
							'is_express_shipping'=> 0,
							'narration'=> null,
							'round_amount'=> 0,
							'discount_amount'=> 0,
							'exchange_rate' => $this->app->epan->default_currency['value'],
							'tnc_id'=>$tnc_id,
							'tnc_text'=> $tnc_text,
							'status' => "OnlineUnpaid"
						];

			$detail_data = [];
			$taxation = $kit_model->applicableTaxation();
			if($taxation instanceof \xepan\commerce\Model_Taxation){
				$taxation_id = $taxation->id;
				$tax_percentage = $taxation['percentage'];
			}else{
				$taxation_id = 0;
				$tax_percentage = 0;
			}

			$qty_unit_id = $kit_model['qty_unit_id'];
			$item = [
				'item_id'=>$kit_model->id,
				'price'=>$kit_model['sale_price'],
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