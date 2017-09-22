<?php

namespace xavoc\mlm;

class Model_SalesInvoice extends \xepan\commerce\Model_SalesInvoice {
	public $table_alias =  'mlm_salesinvoice';

	function init(){
		parent::init();
		
		$this->addExpression('items')->set($this->refSQL('Details')->count());
	}
} 