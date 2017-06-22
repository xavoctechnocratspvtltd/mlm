<?php

namespace xavoc\mlm;


class Model_RepurchaseItem extends \xavoc\mlm\Model_Item{
	function init(){
		parent::init();
		
		$this->addCondition('is_package',false);
	}
}