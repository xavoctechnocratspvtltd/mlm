<?php

namespace xavoc\mlm;


/**
* 
*/
class Model_Distributor_Actions extends \xavoc\mlm\Model_Distributor
{
	
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
			$page->add('View_Warning')->set('payment is already verifed')->addClass('alert alert-danger');
		}
		$attachment = $page->add('xavoc\mlm\Model_Attachment')->addCondition('distributor_id',$this->id);
		$attachment->tryLoadAny();
		$form = $page->add('Form');
		$form->addField('payment_mode')->set($this['payment_mode'])->setAttr('disabled',true);

		$col = $form->add('Columns')->addClass('row');
		$col1 = $col->addColumn(4)->addClass('col-md-4 col-sm-12 col-lg-4 col-xs-12');
		$col2 = $col->addColumn(4)->addClass('col-md-4 col-sm-12 col-lg-4 col-xs-12');
		$col3 = $col->addColumn(4)->addClass('col-md-4 col-sm-12 col-lg-4 col-xs-12');

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

		$col3->add('View_Info')->addClass('alert alert-info')->set('Office/ franchise Deposite');
		$col3->addField('text','deposite_in_office_narration')->set($this['deposite_in_office_narration'])->setAttr('disabled',true);			

		if($attachment['office_receipt_image_id'])
			$col3->add('View')->addClass('col-lg-12 col-md-12 col-sm-12 col-xs-12')->setHtml('<label>Office / Franchise Deposite Receipt Image</label><br/><a target="_blank" style="width:200px;" href="'.$attachment['office_receipt_image'].'"><img style="width:200px;" src="'.$attachment['office_receipt_image'].'"/></a>');		

		$form->setModel($attachment,['payment_narration']);
		$form->addSubmit('Verify Payment')->addClass('btn btn-primary btn-block');

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

	function page_verifyDocument($page){

		if($this['is_document_verified']){
			$page->add('View_Warning')->set('document is already verified')->addClass('alert alert-danger');
		}

		$attachment = $page->add('xavoc\mlm\Model_Attachment')->addCondition('distributor_id',$this->id);
		$attachment->tryLoadAny();

		$form = $page->add('Form');

		$col = $form->add('Columns')->addClass('row');
		$col1 = $col->addColumn(12);

		$no_one_document_found = 1;
		if($attachment['pan_card_id']){
			$col1->add('View')->addClass('col-lg-4 col-md-4 col-sm-12 col-xs-12')->setHtml('<label>Pan Card</label><br/><a target="_blank" style="width:200px;" href="'.$attachment['pan_card'].'"><img style="width:200px;" src="'.$attachment['pan_card'].'"/></a>');
			$no_one_document_found = false;
		}else{
			$col1->add('View')->set('Pan Card Not Submitted')->addClass('alert alert-danger col-lg-4 col-md-4 col-sm-12 col-xs-12');
		}
		
		if($attachment['aadhar_card_id']){
			$col1->add('View')->addClass('col-lg-4 col-md-4 col-sm-12 col-xs-12')->setHtml('<label>Aadhar Card</label><br/><a target="_blank" style="width:200px;" href="'.$attachment['aadhar_card'].'"><img style="width:200px;" src="'.$attachment['aadhar_card'].'"/></a>');
			$no_one_document_found = false;
		}else{
			$col1->add('View')->set('Aadhar Card Not Submitted')->addClass('alert alert-danger col-lg-4 col-md-4 col-sm-12 col-xs-12');
		}

		if($attachment['driving_license_id']){
			$col1->add('View')->addClass('col-lg-4 col-md-4 col-sm-12 col-xs-12')->setHtml('<label>Driving License</label><br/><a target="_blank" style="width:200px;" href="'.$attachment['driving_license'].'"><img style="width:200px;" src="'.$attachment['driving_license'].'"/></a>');
			$no_one_document_found = false;			
		}else{
			$col1->add('View')->set('Driving License Not Submitted')->addClass('alert alert-danger col-lg-4 col-md-4 col-sm-12 col-xs-12');
		}

		$form->setModel($attachment,['document_narration']);
		$form->addSubmit('Verify Document')->addClass('btn btn-primary btn-block');

		if($form->isSubmitted()){
			if($no_one_document_found) {
				return $this->app->page_action_result = $form->js()->univ()->errorMessage('No One Document is found');
			}

			$form->update();
			$this['is_document_verified'] = true;
			$this->save();
			$this->app->page_action_result = $form->js(null,$form->js()->closest('.dialog')->dialog('close'))->univ()->successMessage('Document Verified');
		}
	}

	function page_adminVerify($page){
		$model = $this->add('xavoc\mlm\Model_Kit');
		$model->title_field = "kit_with_price";
		$model->addExpression('kit_with_price')->set(function($m,$q){
			return $q->expr('CONCAT([0]," :: ",[1]," ::",[2])',
									[
										$m->getElement('name'),
										$m->getElement('sku'),
										$m->getElement('sale_price')
									]
				);
		});
		// $page->add('Grid')->setModel($model,['kit_with_price','sale_price']);
		$form = $page->add('Form');
		$kit_field = $form->addField('DropDown','kit');
		$kit_field->setModel($model);
		$kit_field->validate('required');

		$form->addSubmit('Admin Verified And Mark Green')->addClass('btn btn-success');
		if($form->isSubmitted()){

			$attachment = $this->add('xavoc\mlm\Model_Attachment')->addCondition('distributor_id',$this->id)
					->tryLoadAny()
					->save();
			$kit_model = $this->add('xavoc\mlm\Model_Kit')->load($form['kit']);

			// $result = $this->placeOrder($kit_model->id);
			// if($result['status'] == "failed") throw new \Exception($result['message']);

			// $cheque_form->update();
			$this['payment_mode'] = "deposite_in_company";
			$this['deposite_in_office_narration'] = "Admin Verified And Mark Green By System Admin";
			$this->purchaseKit($kit_model);
			$this->markGreen();
			$this->app->page_action_result = $form->js(null,$form->js()->closest('.dialog')->dialog('close'))->univ()->successMessage('Verified and Green');
		}
	}
}