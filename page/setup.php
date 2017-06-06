<?php

namespace xavoc\mlm;

class page_setup extends \Page {
	function init(){
		parent::init();

		$this->add('xavoc\mlm\Model_Distributor')->setupCompany();
	}
}