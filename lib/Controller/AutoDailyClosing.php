<?php

namespace xavoc\mlm;

class Controller_AutoDailyClosing extends \AbstractController {
	function init(){
		parent::init();

		// test if it is running on same date time like
		// save some file with $this->app->now and date(Y-m-d H:i:s) both values some 
		// where that we can test later on

		if($this->app->getConfig('auto_daily_closing',false)){
			return;
		}
		
		$closing_m = $this->add('xavoc\mlm\Model_Closing');
		$closing_m['on_date'] = $this->app->now;
		$closing_m['type'] = "DailyClosing";
		$closing_m->save();
	}
}		