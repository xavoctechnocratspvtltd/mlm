<?php

namespace xavoc\mlm;

class View_VerifyTopupPayment extends \View{

	public $orderid = null;
	public $distributor_id = null;

	function init(){
		parent::init();

		if(!$this->orderid) throw new \Exception("order not found");
		if(!$this->distributor_id) throw new \Exception("distributor not found");
		
		$distributor = $this->add('xavoc\mlm\Model_Distributor')->load($this->distributor_id);

		$order_model = $this->add('xavoc\mlm\Model_SalesOrder');
		if($this->orderid)
			$order_model->load($this->orderid);


		$item = $this->add('xepan\commerce\Model_Item');
		$item->title_field = "kit_with_price";
		$item->addExpression('kit_with_price')->set(function($m,$q){
			return $q->expr('CONCAT([0]," :: ",[1]," ::",[2])',
									[
										$m->getElement('name'),
										$m->getElement('sku'),
										$m->getElement('sale_price')
									]
				);
		});
		$item->addExpression('is_package',true);

		$form = $this->add('Form');
		
		if($order_model->loaded() && $order_model->details()->count()->getOne() == 1 && $order_model['is_topup_included']){
			$topup_oi = $order_model->details()->tryLoadAny();
			$item->load($topup_oi['item_id']);
			$form->add("View")->set($item['kit_with_price'])->addClass('alert alert-info');
			$form->addField('hidden','kit')->set($item->id);
		}else{
			$form->addField('DropDown','kit')->validate('required')->setModel($item);
		}

		// $attachment = $this->add('xavoc\mlm\Model_Attachment')
		// 				->addCondition('distributor_id',$distributor->id);
		// $attachment->tryLoadAny();
		
		$topup_history = $this->add('xavoc\mlm\Model_TopupHistory');
		$topup_history->addCondition('sale_order_id',$order_model->id);
		$topup_history->addCondition('distributor_id',$distributor->id);
		$topup_history->tryLoadAny();

		$payment_mode_field = $form->addField('DropDown','payment_mode')
					->setValueList(['online'=>'Online','cheque'=>'Cheque','dd'=>'DD','deposite_in_franchies'=>'Deposite in Franchises','deposite_in_company'=>'Deposite in company'])
					->set($topup_history['payment_mode']);

		// $form->addField('online_transaction_reference')->setAttr('disabled',true)->set($topup_history['transaction_reference']);
		// $form->addField('online_transaction_detail')->setAttr('disabled',true)->set($topup_history['transaction_detail']);
			
		// $form->addField('bank_name')->set($topup_history['bank_name']);
		// $form->addField('bank_ifsc_code')->set($topup_history['bank_ifsc_code']);
		// $form->addField('cheque_number')->set($topup_history['cheque_number']);
		// $form->addField('dd_number')->set($topup_history['dd_number']);
		// $form->addField('DatePicker','deposite_date')->set($topup_history['dd_date']);

		$form->setModel($topup_history,[
								'online_transaction_reference',
								'online_transaction_detail',
								'bank_name',
								'bank_ifsc_code',
								'cheque_number',
								'dd_number',
								'cheque_date',
								'dd_date',
								'deposite_date',
								'payment_narration',
								'cheque_deposite_receipt_image_id',
								'dd_deposite_receipt_image_id',
								'office_receipt_image_id'
						]);

		$mandatory_field_set = [
					'online'=>['online_transaction_detail','online_transaction_reference'],
					'cheque'=>['bank_name','bank_ifsc_code','cheque_number','cheque_date','deposite_date','cheque_deposite_receipt_image_id'],
					'dd'=>['bank_name','bank_ifsc_code','dd_number','dd_date','deposite_date','dd_deposite_receipt_image_id'],
					'deposite_in_company'=>['payment_narration','office_receipt_image_id'],
					'deposite_in_franchies'=>['payment_narration','office_receipt_image_id']
				];

		$payment_mode_field->js(true)->univ()->bindConditionalShow($mandatory_field_set,'div.atk-form-row');

		$form->addSubmit('Verify Payment')->addClass('btn btn-primary');
		if($form->isSubmitted()){
			// validation check info
			$required_field = $mandatory_field_set[$form['payment_mode']];
			foreach ($required_field as $key => $field_name) {
				if(!$form[$field_name]){
					$form->error($field_name,'must not be empty');
					break;
				}
			}
			
			try{
				$this->app->db->beginTransaction();
				// update attachment info
				$form->model['is_payment_verified'] = true;
				$form->update();
				
				// $distributor['online_transaction_reference'] = $form['online_transaction_reference'];
				// $distributor['online_transaction_detail'] = $form['online_transaction_detail'];
				// $distributor['bank_name'] = $form['bank_name'];
				// $distributor['bank_ifsc_code'] = $form['bank_ifsc_code'];
				// $distributor['cheque_number'] = $form['cheque_number'];
				// $distributor['dd_number'] = $form['dd_number'];
				// $distributor['dd_date'] = $form['dd_date'];
				// $distributor['payment_mode']= $form['payment_mode'];

				$distributor['is_payment_verified'] = true;

				$distributor->save();
				if($order_model->loaded())
					$order_model->invoice()->paid();
				else{
					// create order on dehalf of kit
					$order = $distributor->placeTopupOrder($form['kit']);
					$order->invoice()->paid();
				}
				
				$this->app->db->commit();
			}catch(\Exception $e){
				$this->app->db->rollback();
				$form->js(null,$form->js()->closest('.dialog')->dialog('close'))->univ()->errorMessage($e->getMessage()." , something wrong")->execute();
			}
			
			$form->js(null,$form->js()->closest('.dialog')->dialog('close'))->univ()->successMessage('payment verified and marked green')->execute();
		}

	}
}