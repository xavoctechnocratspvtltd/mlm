<?php

namespace xavoc\mlm;


class Model_Payout extends \xepan\base\Model_Table {
	public $table = "mlm_payout";

	function init(){
		parent::init();

		$this->hasOne('xavoc\mlm\Model_Distributor','distributor_id');
		$this->addField('closing_date')->type('datetime');
		$this->addField('previous_carried_amount')->type('datetime');
		$this->addField('binary_income')->type('money');
		$this->addField('introduction_amount')->type('money');
		$this->addField('retail_profit')->type('money');
		
		$this->addField('rank');
		$this->addField('generation_a_business')->type('int');
		$this->addField('generation_b_business')->type('int');
		$this->addField('re_purchase_incomce_gross')->type('int');
		$this->addField('re_purchase_incomce')->type('int');

		$this->addField('repurchase_bonus')->type('money');
		$this->addField('generation_income')->type('money');
		$this->addField('loyalty_bonus')->type('money');
		$this->addField('leadership_bonus')->type('money');
		$this->addField('gross_payment')->type('datetime');
		$this->addField('tds')->type('datetime');
		$this->addField('net_payment')->type('datetime');
		$this->addField('carried_amount')->type('datetime');

	}

	function dailyClosing($on_date){
		if(!$on_date) $on_date = $this->app->now;

		$pair_pv = '200'; //tail pv
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
			WHERE greened_on is not null
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
			WHERE greened_on is not null
		";
		$this->query($q);
		
	}

	function weeklyClosing($on_date){
		if(!$on_date) $on_date = $this->app->now;
		$this->dailyClosing($on_date);
		// move data to payout table

		// copy all distributors in here
		$q="
			INSERT INTO mlm_payout
						(id,distributor_id,closing_date,previous_carried_amount, binary_income, introduction_amount, retail_profit,generation_income,loyalty_bonus,gross_payment,tds, net_payment,  carried_amount)
				SELECT 	  0,     distributor_id,       '$on_date'  ,carried_amount         , week_pairs   , weekly_intros_amount,      0      ,      0          ,       0     ,     0       , 0 ,     0      ,        0       FROM mlm_distributor WHERE greened_on is not null
		";
		$this->query($q);

		// make weekly figures zero
		$q="UPDATE mlm_distributor SET week_pairs=0, weekly_intros_amount=0 WHERE greened_on is not null";
		$this->query($q);
		
	}

	function monthlyClosing($on_date){
		if(!$on_date) $on_date = $this->app->now;
		$this->weeklyClosing($on_date);
		// add re-purchase bonus & generation income to this payout rows
		// update distributor with A/B legs from bv table ((max) & (All-max))
		$q="UPDATE 
				mlm_payout p
				JOIN mlm_distributor d on p.distributor_id = d.distributor_id
			SET 
				generation_a_business = (select max(bv_sum) from mlm_generation_business bv_table where bv_table.distributor_id = p.distributor_id ),
				generation_b_business = ((select sum(bv_sum) from mlm_generation_business bv_table where bv_table.distributor_id = d.distributor_id ) - (select max(bv_sum) from mlm_generation_business bv_table where bv_table.distributor_id = d.distributor_id ))
			WHERE 
				d.greened_on is not null AND
				closing_date = '$on_date'

				";
		$this->query($q);

		// what if 60% ratio is not maintained ?? 
		// TODO


		// update rank 

		$ranks = $this->add('xavoc\mlm\Model_RePurchaseBonusSlab');

		foreach ($ranks as $row) {
			$q = "
				UPDATE
					mlm_payout p
				SET rank = (select name from mlm_re_purchase_bonus_slab WHERE p.generation_a_business+p.generation_b_business > from_bv AND p.generation_a_business+p.generation_b_business <= to_bv)
				WHERE
					closing_date = '$on_date'
			";

			$this->query($q);
		}

		// generate commission as per slab
		// find difference from introducer downline path
		// 


		// Generation Income

		// calculate loyalty bonus

		// calculate leadership bonus

		// Awards & Rewards
		
	}

	function calculatePayment(){
		// calculate payment tds deduction carry forward etc. inclusing previous carried amount
		// set and save carried_amount to distributor
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