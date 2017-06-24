<?php

namespace xavoc\mlm;

class Model_SalesOrder extends \xepan\commerce\Model_SalesOrder {
	public $table_alias =  'mlm_sale_order';
	public $status = ['Draft','Submitted','Redesign','Approved','InProgress','Canceled','Completed','Dispatched','OnlineUnpaid'];
	public $actions = [
	'Draft'=>['view','edit','delete','manage_attachments','verifyRepurchasePayment'],
	// 'Submitted'=>['view','edit','delete','approve','redesign','manage_attachments','print_document','verifyRepurchasePayment'],
	// 'Approved'=>['view','edit','delete','inprogress','send','manage_attachments','createInvoice','print_document'],
	// 'InProgress'=>['view','edit','delete','cancel','complete','manage_attachments','send'],
	'Canceled'=>['view','edit','delete','redraft','manage_attachments'],
	'Completed'=>['view','edit','delete','manage_attachments','createInvoice','print_document','send'],
	'OnlineUnpaid'=>['view','edit','delete','approve','createInvoice','manage_attachments','print_document','send','verifyRepurchasePayment'],
	// 'Redesign'=>['view','edit','delete','submit','manage_attachments']
				// 'Returned'=>['view','edit','delete','manage_attachments']
	];

	function init(){
		parent::init();

		$this->addExpression('is_topup_included')->set(function($m,$q){
			return $q->expr('IFNULL([0],0)',[$m->refSQL('xavoc\mlm\Model_QSPDetail')->sum('is_package')]);
		});

		$this->hasMany('xavoc\mlm\Model_QSPDetail','qsp_master_id');
	}

	function verifyRepurchasePayment(){
		if(!$this->loaded()) $this->throw('sale ordre model not loaded')->addMoreInfo('in mlm sale order');
		// mark order invoice and paid invoice
		// distribute repurchase value
		// mark order complete and dispatch the goods
		$sale_invoice = $this->invoice();
		$sale_invoice->paid();
		$this->complete();
	}
} 