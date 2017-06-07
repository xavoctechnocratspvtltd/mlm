<?php

namespace xavoc\mlm;


class Model_Payout extends \xepan\base\Model_Table {
	public $table = "mlm_payout";

	function init(){
		parent::init();

		$this->hasOne('xavoc\mlm\Model_Distributor','distributor_id');
		$this->addField('closing_date')->type('datetime');
		$this->addField('week_pairs')->type('number');

	}

	function dailyClosing($on_date){
		if(!$on_date) $on_date = $this->app->now;

		$pair_pv = '1000';
		// $admin_charge = $config['admin_charge'];
		// $min_payout = $config['minimum_payout_amount'];

		// calculate Pairs
		$q="
			UPDATE mlm_distributor
			SET
				day_pairs = IF(day_left_sv > day_right_sv, day_right_sv ,day_left_sv ),
				day_pairs = IF(day_left_sv = day_right_sv AND day_left_sv <> 0 AND day_left_sv <= capping, day_pairs - $pair_pv ,day_pairs),
				day_pairs = IF(day_pairs >= capping, capping, day_pairs),
				week_pairs = week_pairs + day_pairs
		";
		$this->query($q);

		// Set Session PV Carry forwards
		$q="
			UPDATE 
				mlm_distributor d
			SET
				d.temp=0,
				d.temp = IF(d.day_left_sv = d.day_right_sv AND d.day_left_sv > 0, d.day_left_sv - $pair_pv, IF(d.day_left_sv > d.day_right_sv,d.day_right_sv,d.day_left_sv)),
				d.day_left_sv = d.day_left_sv - d.temp,
				d.day_right_sv = d.day_right_sv - d.temp
		";
		$this->query($q);

		
	}

	function weeklyClosing($on_date){
		if(!$on_date) $on_date = $this->app->now;
		$this->dailyClosing($on_date);
		
	}

	function monthlyClosing($on_date){
		if(!$on_date) $on_date = $this->app->now;
		$this->weeklyClosing($on_date);
		
	}

	function calculatePayment(){

	}

	function doClosing($type='daily',$on_date=null){
		if(!$on_date) $on_date = $this->app->now;
		switch ($type) {
			case 'daily':
				$this->dailyClosing($on_date);
				break;
			case 'weekly':
				$this->weeklyClosing($on_date);
				$this->calculatePayment();
				break;
			case 'monthly':
				$this->monthlyClosing($on_date);
				$this->calculatePayment();
				break;
			default:
				throw new \Exception("$type type closing not available", 1);				
				break;
		}
	}

	function query($q){
		$this->api->db->dsql($this->api->db->dsql()->expr($q))->execute();
	}
}