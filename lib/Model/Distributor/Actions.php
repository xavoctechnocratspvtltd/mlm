<?php

namespace xavoc\mlm;


/**
* 
*/
class Model_Distributor_Actions extends \xavoc\mlm\Model_Distributor
{
	public $status = ['Active','Red','KitSelected','KitPaid','Green','InActive'];
	public $actions = [
				'Active'=>['view','edit','delete','InActive'],
				'Red'=>['view','edit','delete'],
				'KitSelected'=>['view','edit','delete','verifyPayment'],
				'KitPaid'=>['view','edit','delete','verifyPayment','markGreen'],
				'Green'=>['view','edit','delete','document'],
				'InActive'=>['view','edit','delete','active'],
				];
	
	function init(){
		parent::init();

		$this->getElement('status')->defaultValue('Red');
	}

	function RedPay(){
		$this['status']='Red';
		$this->app->employee
            ->addActivity("Distributor : '".$this['name']."'  has been InActive", null/* Related Document ID*/, $this->id /*Related Contact ID*/,null,null,null)
            ->notifyWhoCan('Active,Red','InActive',$this);
		$this->saveAndUnload();
	}
	function kitSelected(){
		$this['status']='KitSelected';
		$this->app->employee
            ->addActivity("Distributor : '".$this['name']."'  has been InActive", null/* Related Document ID*/, $this->id /*Related Contact ID*/,null,null,null)
            ->notifyWhoCan('Active,KitSelected','InActive',$this);
		$this->saveAndUnload();
	}

	function InActive(){
		$this['status']='InActive';
		$this->app->employee
            ->addActivity("Distributor : '".$this['name']."'  has been InActive", null/* Related Document ID*/, $this->id /*Related Contact ID*/,null,null,null)
            ->notifyWhoCan('Active,Green','InActive',$this);
		$this->saveAndUnload();
	}

	function page_verifyPayment($page){
		
		if($this['is_payment_verified']){
			$page->add('View_Warning')->set('payment is verifed')->addClass('alert alert-danger');
			return;
		}
		$attachment = $page->add('xavoc\mlm\Model_Attachment')->addCondition('distributor_id',$this->id);
		$attachment->tryLoadAny();

		$form = $page->add('Form');
		$form->addField('payment_mode')->set($this['payment_mode'])->setAttr('disabled',true);

		$col = $form->add('Columns')->addClass('row');
		$col1 = $col->addColumn(6)->addClass('col-md-6 col-sm-12 col-lg-6 col-xs-12');
		$col2 = $col->addColumn(6)->addClass('col-md-6 col-sm-12 col-lg-6 col-xs-12');

		$col1->add('View_Info')->addClass('alert alert-info')->set('Online Transaction Detail');
		$col1->addField('online_transaction_reference')->set($this['transaction_reference'])->setAttr('disabled',true);
		$col1->addField('online_transaction_detail')->set($this['transaction_detail'])->setAttr('disabled',true);

		$col2->add('View_Info')->addClass('alert alert-info')->set('Bank Transaction Detail');
		$col2->addField('bank_name')->set($this['bank_name'])->setAttr('disabled',true);
		$col2->addField('bank_ifsc_code')->set($this['bank_ifsc_code'])->setAttr('disabled',true);
		$col2->addField('cheque_number')->set($this['cheque_number'])->setAttr('disabled',true);
		$col2->addField('dd_number')->set($this['dd_number'])->setAttr('disabled',true);
		$col2->addField('dd_date')->set($this['dd_date'])->setAttr('disabled',true);

		if($attachment['cheque_deposite_receipt_image_id'])
			$col2->add('View')->addClass('col-lg-6 col-md-6 col-sm-12 col-xs-12')->setHtml('<label>Cheque Deposite Receipt Image</label><br/><a target="_blank" style="width:200px;" href="'.$attachment['cheque_deposite_receipt_image'].'"><img style="width:200px;" src="'.$attachment['cheque_deposite_receipt_image'].'"/></a>');
		
		if($attachment['dd_deposite_receipt_image_id'])
			$col2->add('View')->addClass('col-lg-6 col-md-6 col-sm-12 col-xs-12')->setHtml('<label>DD Deposite Receipt Image</label><br/><a target="_blank" style="width:200px;" href="'.$attachment['dd_deposite_receipt_image'].'"><img style="width:200px;" src="'.$attachment['dd_deposite_receipt_image'].'"/></a>');

		$form->setModel($attachment,['payment_narration']);
		$form->addSubmit('Verify Payment')->addClass('btn btn-primary btn-block');

		if($form->isSubmitted()){
			$form->update();
			$this['is_payment_verified'] = true;
			$this->markGreen();
			$this->app->page_action_result = $form->js(null,$form->js()->closest('.dialog')->dialog('close'))->univ()->successMessage('payment verified and marked green');
		}
	}

	function page_verifyDocument($page){
		
		if($this['is_payment_verified']){
			$page->add('View_Warning')->set('payment is verifed')->addClass('alert alert-danger');
			return;
		}

		$form = $page->add('Form');
		$attachment = $page->add('xavoc\mlm\Model_Attachment')->addCondition('distributor_id',$this->id);
		$form->setModel($attachment,['cheque_deposite_receipt_image_id','dd_deposite_receipt_image_id','payment_narration']);
		$form->addSubmit('Verify Payment')->addClass('btn btn-primary');

		if($form->isSubmitted()){
			$form->update();
			$this['is_payment_verified'] = true;
			$this->markGreen();
			$this->app->page_action_result = $form->js(null,$form->js()->closest('.dialog')->dialog('close'))->univ()->successMessage('payment verified and marked green');
		}
		
	}

	function page_payNow($page){
		$page->add('View')->set('Pay Now');
	}

}