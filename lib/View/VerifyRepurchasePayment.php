<?php

namespace xavoc\mlm;

class View_VerifyRepurchasePayment extends \View{
	public $orderid = null;
	public $distributor_id = null;

	function init(){
		parent::init();

		if(!$this->distributor_id) throw new \Exception("distributor not found");
		
		$distributor = $this->add('xavoc\mlm\Model_Distributor')->load($this->distributor_id);
		$order_model = $this->add('xavoc\mlm\Model_SalesOrder');
		if($this->orderid)
			$order_model->load($this->orderid);
		
		// create new order
		$temp_model = $this->add('xavoc\mlm\Model_TemporaryRepurchaseItem');
		$temp_model->addCondition('distributor_id',$distributor->id);

		if(!$order_model->loaded()){
			// $temp_model
			$temp_model->addHook('beforeSave',function($m){
				$kit = $this->add('xavoc\mlm\Model_Item')->load($m['item_id']);
				$m['price'] = $kit['dp'];
			});

			$crud = $this->add('CRUD');
			$crud->setModel($temp_model,['item_id','quantity'],['item','quantity','price']);

			if($crud->isEditing()){
				$c_f = $crud->form;
				$c_f->getElement('item_id')->getModel()->addCondition('is_package',false);
			}
		}

		$repur_model = $this->add('xavoc\mlm\Model_RepurchaseHistory');
		$repur_model->addCondition('distributor_id',$distributor->id);
		if($order_model->loaded()){
			$repur_model->addCondition('sale_order_id',$order_model->id);
			if($repur_model->count()->getOne() > 1)
				throw new \Exception("repurchase order must be one for one order");
			$repur_model->tryLoadAny();
		}

		$form = $this->add('Form');
		$form->setModel($repur_model,[
				'payment_mode',
				
				'online_transaction_reference',
				'online_transaction_detail',
				
				'bank_name',
				'bank_ifsc_code',

				'cheque_number',
				'cheque_date',

				'dd_number',
				'dd_date',

				'deposite_date',

				'cheque_deposite_receipt_image_id',
				'dd_deposite_receipt_image_id',
				'office_receipt_image_id',

				'payment_narration'
			]);

		$payment_mode_field = $form->getElement('payment_mode');

		$mandatory_field_set = [
				'online'=>['online_transaction_detail','online_transaction_reference','payment_narration'],
				'cheque'=>['bank_name','bank_ifsc_code','cheque_number','cheque_date','deposite_date','cheque_deposite_receipt_image_id','payment_narration'],
				'dd'=>['bank_name','bank_ifsc_code','dd_number','dd_date','deposite_date','dd_deposite_receipt_image_id','payment_narration'],
				'deposite_in_company'=>['office_receipt_image_id','payment_narration'],
				'deposite_in_franchies'=>['office_receipt_image_id','payment_narration']
			];
		$payment_mode_field->js(true)->univ()->bindConditionalShow($mandatory_field_set,'div.atk-form-row');
		$form->addSubmit('varify payment')->addClasS('btn btn-primary btn-block');
		if($form->isSubmitted()){
			
			if(!$order_model->loaded() && !$temp_model->count()->getOne()){
				$form->js()->univ()->errorMessage('no one repurchase item found, first add repurchase item')->execute();
			}

			if(!$form['payment_mode'])
				$form->error('payment_mode','must not be empty');

			$required_field = $mandatory_field_set[$form['payment_mode']];
			foreach ($required_field as $key => $field_name) {
				if(!$form[$field_name]){
					$form->error($field_name,'must not be empty');
					break;
				}
			}

			
			try{
				$this->app->db->beginTransaction();

				if(!$order_model->loaded()){
					// create order from
					$result = $distributor->placeRepurchaseOrder();
					if(!isset($result['master_detail']['id']) OR !$result['master_detail']['id']) throw new \Exception("order not created");
					// delete temporary repurchase items
					$temp_oi = $this->add('xavoc\mlm\Model_TemporaryRepurchaseItem');
					$temp_oi->addCondition('distributor_id',$distributor->id);
					$temp_oi->deleteAll();
					$order_id = $result['master_detail']['id'];
					$order_model->load($order_id);
				}

				$form->model['is_payment_verified'] = true;
				$form->update();
				$order_model->invoice()->paid();

				$this->app->db->commit();
			}catch(\Exception $e){
				$this->app->db->rollback();
				throw $e;
			}

			$form->js(null,$form->js()->closest('.dialog')->dialog('close'))->univ()->successMessage('payment verified')->execute();
		}


	}
}