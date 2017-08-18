<?php

namespace xavoc\mlm;

class Model_Order_TopupDeliver extends \xavoc\mlm\Model_Order_Topup {

	public $actions = [
		'Draft'=>['view','edit','delete','dispatch','verify_Payment'],
		'Submitted'=>['view','edit','delete','dispatch','verify_Payment','print_document'],
		'Approved'=>['view','edit','delete','dispatch','verify_Payment','assign_for_shipping','print_document'],
		'InProgress'=>['view','edit','delete','dispatch','verify_Payment','complete','print_document'],
		'Canceled'=>['view','edit','delete','redraft'],
		'Completed'=>['view','edit','delete','dispatch','verify_Payment','print_document'],
		'OnlineUnpaid'=>['view','edit','delete','dispatch','verify_Payment','print_document'],
		'Redesign'=>['view','edit','delete','submit']
	];

	function init(){
		parent::init();

		$this->addCondition('is_payment_verified',true);
		$this->addCondition('is_delivered',false);
	}

}
