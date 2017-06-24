<?php

namespace xavoc\mlm;

class Model_QSPDetail extends \xepan\commerce\Model_QSP_Detail {

	function init(){
		parent::init();
		
		$this->addExpression('is_package')->set($this->refSQL("item_id")->fieldQuery('is_package'));
	}
} 