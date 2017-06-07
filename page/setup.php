<?php

namespace xavoc\mlm;

class page_setup extends \Page {
	function init(){
		parent::init();

		// truncate 
		// contact, employee, customer, distributor, kit item, specification etc tables
		// add new default employee
		// add default specifications
		// create a few kits with different SV BV Capping and Introduction Income
		// 	to create kit first create an array and then create kit in foreach so we can add other kits easily

		$this->add('xavoc\mlm\Model_Distributor')->setupCompany();
	}
}