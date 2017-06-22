<?php


namespace xavoc\mlm;

class Model_Closing_Weekly extends Model_Closing {
	function init(){
		parent::init();

		$this->addCondition('type','WeeklyClosing');
		$this->addCondition('calculate_loyalty',false);
	}
}