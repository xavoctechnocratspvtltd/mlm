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

		$attachment = $this->add('xavoc\mlm\Model_Attachment')
						->addCondition('distributor_id',$distributor->id);
		$attachment->tryLoadAny();
		
		$payment_mode_field = $form->addField('DropDown','payment_mode')
					->setValueList(['online'=>'Online','cheque'=>'Cheque','dd'=>'DD','deposite_in_franchies'=>'Deposite in Franchises','deposite_in_company'=>'Deposite in company'])
					->set($distributor['payment_mode']);

		$form->addField('online_transaction_reference')->set($distributor['transaction_reference'])->setAttr('disabled',true);
		$form->addField('online_transaction_detail')->set($distributor['transaction_detail'])->setAttr('disabled',true);
		
		$form->addField('bank_name')->set($distributor['bank_name']);
		$form->addField('bank_ifsc_code')->set($distributor['bank_ifsc_code']);
		$form->addField('cheque_number')->set($distributor['cheque_number']);
		$form->addField('dd_number')->set($distributor['dd_number']);
		$form->addField('dd_date')->set($distributor['dd_date']);

		$form->setModel($attachment,['payment_narration','cheque_deposite_receipt_image_id','dd_deposite_receipt_image_id','office_receipt_image_id']);

		$payment_mode_field->js(true)->univ()->bindConditionalShow([
					'online'=>['online_transaction_detail','online_transaction_reference'],
					'cheque'=>['bank_name','bank_ifsc_code','cheque_number','cheque_deposite_receipt_image_id'],
					'dd'=>['bank_name','bank_ifsc_code','dd_number','dd_date','dd_deposite_receipt_image_id'],
					'deposite_in_company'=>['payment_narration','office_receipt_image_id'],
					'deposite_in_franchies'=>['payment_narration','office_receipt_image_id']
				],'div.atk-form-row');

		$form->addSubmit('Verify Payment')->addClass('btn btn-primary');
		if($form->isSubmitted()){
			$form->update();

			$distributor['is_payment_verified'] = true;
			$distributor->save();
			if($order_model->loaded())
				$order_model->invoice()->paid();

			// create order on dehalf of kit

			// $distributor->markGreen();
			// $distributor->purchaseKit($form['kit']);
			$form->js(null,$form->js()->closest('.dialog')->dialog('close'))->univ()->successMessage('payment verified and marked green')->execute();
		}

	}
}