<?php

namespace xavoc\mlm;

class Controller_AutoDailyClosing extends \AbstractController {
	function init(){
		parent::init();

		return;
		$closing_m = $this->add('xavoc\mlm\Model_Closing');
		$closing_m['on_date'] = $this->app->now;
		$closing_m['type'] = "DailyClosing";
		$closing_m->save();
	}
}		