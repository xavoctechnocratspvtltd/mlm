<?php

namespace xavoc\mlm;


class Model_Closing extends \xepan\base\Model_Table {
	public $table = "mlm_closing";

	function init(){
		parent::init();

		$this->hasOne('xavoc\mlm\Model_Distributor','distributor_id');
		$this->addField('closing_date')->type('datetime');
		$this->addField('week_left_sv')->type('number');
		$this->addField('week_right_sv')->type('number');
		$this->addField('week_carried_left_pv')->type('number');

	}

	function dailyClosing($on_date){
		if(!$on_date) $on_date = $this->app->now;
		
	}

	function weeklyClosing($on_date){
		if(!$on_date) $on_date = $this->app->now;
		
	}

	function monthlyClosing($on_date){
		if(!$on_date) $on_date = $this->app->now;
		
	}



	function doClosing($on_date=null){
		if(!$on_date) $on_date = $this->app->now;
	}
}