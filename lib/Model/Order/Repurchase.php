<?php

namespace xavoc\mlm;

class Model_Order_Repurchase extends \xavoc\mlm\Model_SalesOrder {

	public $actions = [
		'Draft'=>['view','edit','delete','verify_Payment'],
		'Submitted'=>['view','edit','delete','verify_Payment','print_document'],
		'Approved'=>['view','edit','delete','verify_Payment','assign_for_shipping','print_document'],
		'InProgress'=>['view','edit','delete','verify_Payment','complete','print_document'],
		'Canceled'=>['view','edit','delete','redraft'],
		'Completed'=>['view','edit','delete','verify_Payment','print_document'],
		'OnlineUnpaid'=>['view','edit','delete','verify_Payment','print_document'],
		'Redesign'=>['view','edit','delete','submit']
	];

	function init(){
		parent::init();

		$this->addExpression('repurchase_history_count')->set(function($m,$q){
			return $q->expr('[0]',[$m->add('xavoc\mlm\Model_RepurchaseHistory')->addCondition('sale_order_id',$q->getField('id'))->count()]);
		});

		$this->addExpression('is_payment_verified')->set(function($m,$q){
			$th = $m->add('xavoc\mlm\Model_RepurchaseHistory')
				->addCondition('sale_order_id',$q->getField('id'))
				;
			return $q->expr('IFNULL([0],0)',[$th->fieldQuery('is_payment_verified')]);
		})->type('boolean');


		$this->addExpression('user')->set(function($m,$q){
			return $m->refSQL('contact_id')->fieldQuery('user');
		});

		$this->addCondition('repurchase_history_count','>',0);

		$this->addCondition('is_topup_included',false);
	}

	function page_verify_Payment($page){

		$th = $this->add('xavoc\mlm\Model_RepurchaseHistory');
		$th->addCondition('sale_order_id',$this->id);
		if($th->count()->getOne() > 1){
			$page->add('View')->set('more than one repurchase payment record found');
			return;
		}
		$th->tryLoadAny();

		if(!$th->loaded()){
			$page->add('View')->set('Payment detail is not submitted');
			return;
		}

		if($th['is_payment_verified']){
			$page->add('View')->set('Payment is alreay verified')->addClass('alert alert-success');
		}

		switch ($th['payment_mode']) {
			case 'online':
				$field_list = ['payment_narration','online_transaction_reference','online_transaction_detail'];
				$image_field = 0;
			break;
			case 'cheque':
				$field_list = ['payment_narration','bank_name','bank_ifsc_code','cheque_number','cheque_date'];
				$image_field = 'cheque_deposite_receipt_image';
			break;
			case 'dd':
				$field_list = ['payment_narration','bank_name','bank_ifsc_code','dd_number','dd_date'];
				$image_field = 'dd_deposite_receipt_image';
			break;
			case 'deposite_in_franchies':
				$field_list = ['payment_narration'];
				$image_field = 'office_receipt_image';
			break;
			case 'deposite_in_company':
				$field_list = ['payment_narration'];
				$image_field = 'office_receipt_image';
			break;
		}
		
		$form = $page->add('Form');
		$form->add('View')->setHtml('Payment Deposite Via : <strong>'.$th['payment_mode'].'</strong>'.' deposite on date: <strong>'.$th['deposite_date'].'</strong>')->addClass('alert alert-info');
		
		$cols = $form->add('Columns');
		$col1 = $cols->addColumn(8)->addClass('col-md-6 col-lg-6 col-sm-12 col-xs-12');
		$col2 = $cols->addColumn(4)->addClass('col-md-6 col-lg-6 col-sm-12 col-xs-12');

		foreach ($field_list as $key => $field) {
			$col1->add('View')->setHtml(strtoupper($field).': <strong>'.$th[$field].'</strong>');
		}

		if($image_field){
			$col2->add('View')->setHtml('<a target="_blank" href="'.$th[$image_field].'"><img style="width:100%;" src="'.$th[$image_field].'" /></a>');
		}

		if(!$th['is_payment_verified'])
			$form->addSubmit('Verify Payment')->addClass('btn btn-primary');

		if($form->isSubmitted()){

			$th['is_payment_verified'] = true;
			$th->save();
			$this->complete();
			$this->invoice()->paid();
			// $dist = $this->add('xavoc\mlm\Model_Distributor');
			// $dist->load($this['contact_id']);
			// $dist->markGreen();
			$this->app->page_action_result = $form->js(null,$form->js()->closest('.dialog')->dialog('close'))->univ()->successMessage('payment verified successfully');
		}

	}
}
