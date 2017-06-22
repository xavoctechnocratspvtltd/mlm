<?php


namespace xavoc\mlm;

class Model_Closing_Daily extends Model_Closing {
	function init(){
		parent::init();

		$this->addCondition('type','DailyClosing');
		$this->addCondition('calculate_loyalty',false);
	}
}