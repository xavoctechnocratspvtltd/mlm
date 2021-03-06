<?php

namespace xavoc\mlm;

class View_RepurchasePaymentMode extends \View{

	public $options= ['checkout_page'=>'checkout'];

	function init(){
		parent::init();


		$distributor = $this->add('xavoc\mlm\Model_Distributor');
		$distributor->loadLoggedIn();
		if(!$distributor->loaded()){
			$this->add('View_Error')->set('distributor not found');
			return;
		}

		// check address must not be empty
		if(!$distributor['country_id'] OR !$distributor['state_id'] OR !$distributor['address'] OR !$distributor['city'] OR ! $distributor['pin_code']){
			$v = $this->add('View')->addClass('alert alert-warning');
			$v->add('View')->set("please update your country,state, address and profile");
			$v->add('Button')->addClass('btn btn-warning')->set('Go To Setting')->js('click')->univ()->redirect('setting');
			return;
		}

		$tabs = $this->add('Tabs');
		$df_tab = $tabs->addTab('Deposite in Franchises \ Company');
		$dd_tab = $tabs->addTab('Demand Draft');
		$cheque_tab = $tabs->addTab('Cheque');
		// $online_tab = $tabs->addTab('Pay Online');

		// deposite in company
		$form = $df_tab->add('Form');
		$field = $form->addField('Upload','office_receipt_image_id');
		$field->setModel('xepan\filestore\Image');

		$form->addField('text','narration');
		$form->addField('checkbox','deposite_in_company');
		$form->addSubmit('Submit')->addClass('btn btn-primary');

		if($form->isSubmitted()){
			if(!$form['office_receipt_image_id']) $form->error('office_receipt_image_id','must not be empty');
									
			try{
				$this->app->db->beginTransaction();

				$result = $distributor->placeRepurchaseOrder();
				if(!isset($result['master_detail']['id']) OR !$result['master_detail']['id']) throw new \Exception("order not created");

				// delete temporary repurchase items
				$temp_oi = $this->add('xavoc\mlm\Model_TemporaryRepurchaseItem');
				$temp_oi->addCondition('distributor_id',$distributor->id);
				$temp_oi->deleteAll();

				$order_id = $result['master_detail']['id'];
				$payment_mode = $form['deposite_in_company']?'deposite_in_company':'deposite_in_franchies';
				$payment_detail = [
							'office_receipt_image_id' => $form['office_receipt_image_id'],
							'dd_deposite_receipt_image_id' => 0,
							'cheque_deposite_receipt_image_id' => 0,
							'payment_narration' => $form['narration']
						];

				$distributor->updateRepurchaseHistory($order_id,$payment_mode,$payment_detail);

				$this->app->db->commit();
				}catch(\Exception $e){
					$this->app->db->rollback();
					$form->js()->univ()->errorMessage($e->getMessage())->execute();
				}
				$order_no = $result['master_detail']['document_no'];
				$form->js(null,$form->js()->redirect($this->app->url(null,['message'=>'Order Placed Successfully, Order No:'.$order_no])))->univ()->execute();
				// $form->js(null,$form->js()->redirect($this->app->url('dashboard')))->univ()->successMessage('Order Placed and Payment Detail Submitted')->execute();
		}


		// dd deposite
		$dd_form = $dd_tab->add('Form');
		$dd_form->addField('bank_name')->validate('required');
		$dd_form->addField('bank_ifsc_code')->validate('required');
		$dd_form->addField('dd_number')->validate('required');
		$dd_form->addField('DatePicker','dd_date')->validate('required');
		$dd_form->addField('DatePicker','deposite_date')->validate('required');
		$dd_form->addField('text','narration');

		$field = $dd_form->addField('Upload','dd_deposite_receipt_image_id');
		$field->setModel('xepan\filestore\Image');

		$dd_form->addSubmit('Submit')->addClass('btn btn-primary');
		if($dd_form->isSubmitted()){
			
			if(!$dd_form['dd_deposite_receipt_image_id']) $dd_form->error('dd_deposite_receipt_image_id','must not be empty');
			if(!$dd_form['dd_date']) $dd_form->error('dd_date','must not be empty');
						
			try{
				$this->app->db->beginTransaction();

				$result = $distributor->placeRepurchaseOrder();
				if(!isset($result['master_detail']['id']) OR !$result['master_detail']['id']) throw new \Exception("order not created");

				// delete temporary repurchase items
				$temp_oi = $this->add('xavoc\mlm\Model_TemporaryRepurchaseItem');
				$temp_oi->addCondition('distributor_id',$distributor->id);
				$temp_oi->deleteAll();

				$order_id = $result['master_detail']['id'];
				$payment_mode = 'dd';
				$payment_detail = [
							'bank_name'=>$dd_form['bank_name'],
							'bank_ifsc_code'=>$dd_form['bank_ifsc_code'],
							'dd_number'=>$dd_form['dd_number'],
							'dd_date'=>$dd_form['dd_date'],
							'deposite_date'=>$dd_form['deposite_date'],
							'office_receipt_image_id' => 0,
							'dd_deposite_receipt_image_id' => $dd_form['dd_deposite_receipt_image_id'],
							'cheque_deposite_receipt_image_id' => 0,
							'payment_narration' => $dd_form['narration']
						];

				$distributor->updateRepurchaseHistory($order_id,$payment_mode,$payment_detail);

				$this->app->db->commit();
				}catch(\Exception $e){
					$this->app->db->rollback();
					$dd_form->js()->univ()->errorMessage($e->getMessage())->execute();
				}

				$order_no = $result['master_detail']['document_no'];
				$dd_form->js(null,$dd_form->js()->redirect($this->app->url(null,['message'=>'Order Placed Successfully, Order No:'.$order_no])))->univ()->execute();
				// $dd_form->js(null,$dd_form->js()->redirect($this->app->url('dashboard')))->univ()->successMessage('Order Placed and Payment Detail Submitted')->execute();
		}
		// end of dd--------

		// cheque tab
		$cheque_form = $cheque_tab->add('Form');
		$cheque_form->addField('bank_name')->validate('required');
		$cheque_form->addField('bank_ifsc_code')->validate('required');
		$cheque_form->addField('cheque_number')->validate('required');
		$cheque_form->addField('DatePicker','cheque_date')->validate('required');
		$cheque_form->addField('DatePicker','deposite_date');
		$cheque_form->addField('text','narration');

		$field = $cheque_form->addField('Upload','cheque_deposite_receipt_image_id');
		$field->setModel('xepan\filestore\Image');

		$cheque_form->addSubmit('Submit')->addClass('btn btn-primary');
		
		if($cheque_form->isSubmitted()){

			if(!$cheque_form['cheque_deposite_receipt_image_id']) $cheque_form->error('cheque_deposite_receipt_image_id','must not be empty');
			if(!$cheque_form['cheque_date']) $cheque_form->error('cheque_date','must not be empty');
			
			try{
				$this->app->db->beginTransaction();

				$result = $distributor->placeRepurchaseOrder();
				if(!isset($result['master_detail']['id']) OR !$result['master_detail']['id']) throw new \Exception("order not created");

				// delete temporary repurchase items
				$temp_oi = $this->add('xavoc\mlm\Model_TemporaryRepurchaseItem');
				$temp_oi->addCondition('distributor_id',$distributor->id);
				$temp_oi->deleteAll();

				$order_id = $result['master_detail']['id'];
				$payment_mode = 'cheque';
				$payment_detail = [
							'bank_name'=>$cheque_form['bank_name'],
							'bank_ifsc_code'=>$cheque_form['bank_ifsc_code'],
							'cheque_number'=>$cheque_form['cheque_number'],
							'cheque_date'=>$cheque_form['cheque_date'],
							'deposite_date'=>$cheque_form['deposite_date'],
							'office_receipt_image_id' => 0,
							'dd_deposite_receipt_image_id' => 0,
							'cheque_deposite_receipt_image_id' => $cheque_form['cheque_deposite_receipt_image_id'],
							'payment_narration' => $cheque_form['narration']
						];

				$distributor->updateRepurchaseHistory($order_id,$payment_mode,$payment_detail);

				$this->app->db->commit();
				}catch(\Exception $e){
					$this->app->db->rollback();
					$cheque_form->js()->univ()->errorMessage($e->getMessage())->execute();
				}
				
				$order_no = $result['master_detail']['document_no'];
				$cheque_form->js(null,$cheque_form->js()->redirect($this->app->url(null,['message'=>'Order Placed Successfully, Order No:'.$order_no])))->univ()->execute();
				// $cheque_form->js(null,$cheque_form->js()->redirect($this->app->url('dashboard')))->univ()->successMessage('Order Placed and Payment Detail Submitted')->execute();
		}

		// pay via online process
		// $online_pay_btn = $online_tab->add('Button')->set("pay via online")->addClass('btn btn-primary');
		// if($online_pay_btn->isClicked()){

		// 	$order_id = 0;
		// 	try{
		// 		$this->app->db->beginTransaction();

				
		// 		$result = $distributor->placeRepurchaseOrder();
		// 		if(!isset($result['master_detail']['id']) OR !$result['master_detail']['id']) throw new \Exception("order not created");
		// 		$order_id = $result['master_detail']['id'];

		// 		// delete temporary repurchase items
		// 		$temp_oi = $this->add('xavoc\mlm\Model_TemporaryRepurchaseItem');
		// 		$temp_oi->addCondition('distributor_id',$distributor->id);
		// 		$temp_oi->deleteAll();
		// 		$payment_mode = "online";

		// 		$distributor->updateRepurchaseHistory($order_id,$payment_mode,[]);

		// 		$this->app->db->commit();
		// 	}catch(\Exception $e){
		// 		$this->app->db->rollback();
		// 		$this->js()->univ()->errorMessage($e->getMessage())->execute();
		// 	}

		// 	if($order_id){
		// 		$url = $this->app->url($this->options['checkout_page'],['order_id'=>$order_id,'step'=>'payment','pay_now'=>true]);
		// 		$js_event = [
		// 			$this->app->js()->univ()->redirect($url),
		// 			$this->app->js()->univ()->closeDialog()
		// 		];

		// 		$this->js(null,$js_event)->univ()->successMessage('redirecting to payment gateway ...')->execute();
		// 	}
		// }


	}
};