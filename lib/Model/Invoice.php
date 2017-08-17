<?php

namespace xavoc\mlm;


/**
* 
*/
class Model_Invoice extends \xepan\commerce\Model_SalesInvoice{

	function init(){
		parent::init();

		$this->addExpression('username')->set($this->refSQL('contact_id')->fieldQuery('user'));
		$this->addExpression('mobile_no')->set($this->refSQL('contact_id')->fieldQuery('contacts_str'));
	}

}