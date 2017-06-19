<?php


namespace xavoc\mlm;

class Model_Closing_Monthly extends Model_Closing {
	function init(){
		parent::init();

		$this->addCondition('type','MonthlyClosing');
	}
}