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

		
		if(!($this->app->getConfig('auto_daily_closing',false) && $c_s_m['auto_daily_closing'])){
			echo "auto closing off in config, returning";
			return;
		}
		
		try{
			// daily 
			$this->app->db->beginTransaction();
			$closing_m = $this->add('xavoc\mlm\Model_Closing');
			$closing_m['on_date'] = $this->app->today;
			$closing_m['type'] = "DailyClosing";
			$closing_m->save();

			// weekly
			if(date('w', strtotime($this->app->today)) == $c_s_m['weekly_closing_day']){
				$closing_m = $this->add('xavoc\mlm\Model_Closing');
				$closing_m->addCondition('on_date',$this->app->today);
				$closing_m->addCondition('type',"WeeklyClosing");
				$closing_m->tryLoadAny();
				if(!$closing_m->loaded()){
					$closing_m->save();
				}
			}

			$this->app->db->commit();
		}catch(\Exception $e){
			$this->app->db->rollback();
			throw $e;
		}
	}
}		