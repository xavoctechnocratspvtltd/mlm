<?php

namespace xavoc\mlm;

class View_RepurchasePaymentMode extends \View{

	public $options= [];

	function init(){
		parent::init();


		$distributor = $this->add('xavoc\mlm\Model_Distributor');
		$distributor->loadLoggedIn();
		if(!$distributor->loaded()){
			$this->add('View_Error')->set('distributor not found');
			return;
		}

		$tabs = $this->add('Tabs');
		$df_tab = $tabs->addTab('Deposite in Franchises \ Company');
		$cheque_tab = $tabs->addTab('Cheque');
		$dd_tab = $tabs->addTab('Demand Draft');
		$online_tab = $tabs->addTab('Pay Online');

		// deposite in company
		$form = $df_tab->add('Form');
		$field = $form->addField('Upload','office_receipt_image_id');
		$field->setModel('xepan\filestore\Image');

		$form->addField('text','narration');
		$form->addField('checkbox','deposite_in_company');
		$form->addSubmit('Submit')->addClass('btn btn-primary');

		if($form->isSubmitted()){
			try{
				$this->app->db->beginTransaction();

				$result = $distributor->placeRepurchaseOrder();
				if(!isset($result['master_detail']['id']) OR !$result['master_detail']['id']) throw new \Exception("order not created");
								
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
				$form->js(null,$form->js()->redirect($this->app->url('dashboard')))->univ()->successMessage('Order Placed and Payment Detail Submitted')->execute();
		}

		
		// dd deposite
		$dd_form = $dd_tab->add('Form');
		$dd_form->addField('bank_name')->validate('required');
		$dd_form->addField('bank_ifsc_code')->validate('required');
		$dd_form->addField('dd_number')->validate('required');
		$dd_form->addField('DatePicker','dd_date')->validate('required');

		$field = $dd_form->addField('Upload','dd_deposite_receipt_image_id');
		$field->setModel('xepan\filestore\Image');

		// $dd_form->setModel($attachment,['dd_deposite_receipt_image_id']);
		$dd_form->addSubmit('Submit')->addClass('btn btn-primary');
		if($dd_form->isSubmitted()){
			if(!$dd_form['dd_deposite_receipt_image_id']) $dd_form->error('dd_deposite_receipt_image_id','must not be empty');
			if(!$dd_form['dd_date']) $dd_form->error('dd_date','must not be empty');
			
			$attachment['dd_deposite_receipt_image_id'] = $dd_form['dd_deposite_receipt_image_id'];
			$attachment['cheque_deposite_receipt_image_id'] = 0;
			$attachment['office_receipt_image_id'] = 0;

			$attachment->save();
			// $dd_form->update();
			$result = $this->placeOrder($kit_model->id);
			if($result['status'] == "failed") throw new \Exception($result['message']);

			$distributor['payment_mode'] = "dd";
			$distributor['bank_name'] = $dd_form['bank_name'];
			$distributor['bank_ifsc_code'] = $dd_form['bank_ifsc_code'];
			$distributor['cheque_number'] = $dd_form['cheque_number'];
			$distributor['cheque_date'] = $dd_form['cheque_date'];
			// $distributor->purchaseKit($kit_model);

			$dd_form->js(null,$dd_form->js()->redirect($this->app->url('dashboard')))->univ()->successMessage('DD detail submitted')->execute();
		}
		// end of dd--------

		// cheque tab
		$cheque_form = $cheque_tab->add('Form');
		$cheque_form->addField('bank_name')->validate('required');
		$cheque_form->addField('bank_ifsc_code')->validate('required');
		$cheque_form->addField('cheque_number')->validate('required');
		$cheque_form->addField('DatePicker','cheque_date')->validate('required');

		$field = $cheque_form->addField('Upload','cheque_deposite_receipt_image_id');
		$field->setModel('xepan\filestore\Image');
		// $cheque_form->setModel($attachment,['cheque_deposite_receipt_image_id']);
		$cheque_form->addSubmit('Submit')->addClass('btn btn-primary');
		
		if($cheque_form->isSubmitted()){

			if(!$cheque_form['cheque_deposite_receipt_image_id']) $cheque_form->error('cheque_deposite_receipt_image_id','must not be empty');
			if(!$cheque_form['cheque_date']) $cheque_form->error('cheque_date','must not be empty');

			$attachment['cheque_deposite_receipt_image_id'] = $cheque_form['cheque_deposite_receipt_image_id'];
			$attachment['dd_deposite_receipt_image_id'] = 0;
			$attachment['office_receipt_image_id'] = 0;

			$attachment->save();

			$result = $this->placeOrder($kit_model->id);
			if($result['status'] == "failed") throw new \Exception($result['message']);

			// $cheque_form->update();
			$distributor['payment_mode'] = "cheque";
			$distributor['kit_id'] = $cheque_form['bank_name'];
			$distributor['bank_name'] = $cheque_form['bank_name'];
			$distributor['bank_ifsc_code'] = $cheque_form['bank_ifsc_code'];
			$distributor['cheque_number'] = $cheque_form['cheque_number'];
			$distributor['cheque_date'] = $cheque_form['cheque_date'];
			// $distributor->purchaseKit($kit_model);

			$cheque_form->js(null,$cheque_form->js()->redirect($this->app->url('dashboard')))->univ()->successMessage('cheque detail submitted')->execute();
		}

		// pay via online process
		$online_pay_btn = $online_tab->add('Button')->set("pay via online")->addClass('btn btn-primary');
		if($online_pay_btn->isClicked()){

			$result = $this->placeOrder($this->kit_id);
			// for online working based on hook so topup history called
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
	}
};