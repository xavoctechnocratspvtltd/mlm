<?php

namespace xavoc\mlm;

class Controller_AutoDailyClosing extends \AbstractController {
	function init(){
		parent::init();

		// test if it is running on same date time like
		// save some file with $this->app->now and date(Y-m-d H:i:s) both values some 
		// where that we can test later on

		$c_s_m = $this->add('xepan\base\Model_ConfigJsonModel',
				[
					'fields'=>[
								'mark_green_stopped'=>'checkbox',
								'enable_closing'=>'checkbox',
								'new_registration_stopped'=>'checkbox',
								'auto_daily_closing'=>'checkbox',
								'weekly_closing_day'=>'DropDown',
								'monthly_closing_date'=>'DropDown',
							],
						'config_key'=>'CLOSING_RELATED_CONFIG',
						'application'=>'mlm'
				]);
		$c_s_m->tryLoadAny();

		if($this->app->getConfig('auto_daily_closing',false) AND $c_s_m['auto_daily_closing']){
			echo "auto closing off in config, returning";
			return;
		}
		
		$closing_m = $this->add('xavoc\mlm\Model_Closing');
		$closing_m['on_date'] = $this->app->today;
		$closing_m['type'] = "DailyClosing";
		$closing_m->save();
	}
}		