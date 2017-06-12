<?php

namespace xavoc\mlm;


/**
* 
*/
class Model_Distributor_Actions extends \xavoc\mlm\Model_Distributor
{
	public $status = ['Active','Red','KitSelected','KitPaid','Green','InActive'];
	public $actions = [
				'Red'=>['view','edit','delete'],
				'KitSelected'=>['view','edit','delete','verifyPayment','Document'],
				'KitPaid'=>['view','edit','delete','verifyPayment','markGreen'],
				'Green'=>['view','edit','delete','Document'],
				'Blocked'=>['view','edit','delete','Unblocked']
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

	function page_Document($page){

		$tab = $page->add('Tabs');
		$tab_doc = $tab->addTab('Document');
		$tab_pay = $tab->addTab('Payment Related Document');

		$attachment = $tab_doc->add('xavoc\mlm\Model_Attachment');
		$attachment->addCondition('distributor_id',$this->id);
		$attachment->tryLoadAny();

		$crud = $tab_doc->add('xepan\hr\CRUD',['allow_add'=>false]);
		$crud->grid->addHook('formatRow',function($g){
			$g->current_row_html['pan_card'] = '<a href="'.$g->model['pan_card'].'" target="_blank"><img style="width: 200px;" src="'.$g->model['pan_card'].'"/></a>';
			$g->current_row_html['aadhar_card'] = '<a href="'.$g->model['aadhar_card'].'" target="_blank"><img <img style="width: 200px;" src="'.$g->model['aadhar_card'].'"></a>';
			$g->current_row_html['driving_license'] = '<a href="'.$g->model['driving_license'].'" target="_blank"><img <img style="width: 200px;" src="'.$g->model['driving_license'].'"></a>';
			$g->current_row_html['delete'] = " ";
		});
		$crud->setModel($attachment,['distributor','pan_card_id','pan_card','aadhar_card_id','aadhar_card','driving_license_id','driving_license','document_narration'],['pan_card','aadhar_card','driving_license','document_narration']);
		$crud->grid->removeColumn('attachment_icon');
		$crud->grid->removeColumn('cheque_deposite_receipt_image');
		$crud->grid->removeColumn('dd_deposite_receipt_image');
		$crud->grid->removeColumn('action');
		$crud->grid->removeColumn('delete');
		$crud->grid->removeColumn('payment_narration');

		// payment related document
		$attachment = $tab_doc->add('xavoc\mlm\Model_Attachment');
		$attachment->addCondition('distributor_id',$this->id);
		$attachment->tryLoadAny();
		$crud = $tab_pay->add('xepan\hr\CRUD',['allow_add'=>false]);
		$crud->grid->addHook('formatRow',function($g){
			$g->current_row_html['cheque_deposite_receipt_image'] = '<a href="'.$g->model['cheque_deposite_receipt_image'].'" target="_blank"><img style="width: 200px;" src="'.$g->model['cheque_deposite_receipt_image'].'"/></a>';
			$g->current_row_html['dd_deposite_receipt_image'] = '<a href="'.$g->model['dd_deposite_receipt_image'].'" target="_blank"><img <img style="width: 200px;" src="'.$g->model['dd_deposite_receipt_image'].'"></a>';
			$g->current_row_html['delete'] = " ";
		});
		$crud->setModel($attachment,['distributor','cheque_deposite_receipt_image_id','cheque_deposite_receipt_image','dd_deposite_receipt_image','dd_deposite_receipt_image_id','payment_narration']);
		$crud->grid->removeColumn('attachment_icon');
		$crud->grid->removeColumn('pan_card');
		$crud->grid->removeColumn('aadhar_card');
		$crud->grid->removeColumn('driving_license');
		$crud->grid->removeColumn('action');
		$crud->grid->removeColumn('delete');
		$crud->grid->removeColumn('document_narration');
		$crud->grid->removeColumn('cheque_deposite_receipt_image_id');
		$crud->grid->removeColumn('dd_deposite_receipt_image_id');
	}

	function page_payNow($page){
		$page->add('View')->set('Pay Now');
	}

}