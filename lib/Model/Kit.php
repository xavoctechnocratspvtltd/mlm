<?php

namespace xavoc\mlm;


class Model_Kit extends \xavoc\mlm\Model_Item {
	// public $table = "item";

	function init(){
		parent::init();

		$this->addCondition('sv','<>',null);

	}
}