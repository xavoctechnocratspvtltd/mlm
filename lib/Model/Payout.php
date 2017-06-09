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
		$this->addField('slab_percentage')->type('number');

		$this->addField('generation_a_business')->type('int');
		$this->addField('generation_b_business')->type('int');
		$this->addField('re_purchase_income_gross')->type('int');

		$this->addField('repurchase_bonus')->type('money');
		
		$this->addField('generation_income_1')->type('money');
		$this->addField('generation_income_2')->type('money');
		$this->addField('generation_income_3')->type('money');
		$this->addField('generation_income_4')->type('money');
		$this->addField('generation_income_5')->type('money');
		$this->addField('generation_income_6')->type('money');
		$this->addField('generation_income_7')->type('money');

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
						(id,distributor_id,closing_date,previous_carried_amount, binary_income, introduction_amount, retail_profit,slab_percentage,month_self_bv,generation_income,loyalty_bonus,gross_payment,tds, net_payment,  carried_amount)
				SELECT 	  0,distributor_id,'$on_date'  ,carried_amount         , week_pairs   , weekly_intros_amount,         0   ,          0    ,month_self_bv,      0          ,       0     ,     0       , 0 ,     0      ,        0       FROM mlm_distributor WHERE greened_on is not null
		";
		$this->query($q);

		// make weekly figures zero
		$q="UPDATE mlm_distributor SET week_pairs=0, weekly_intros_amount=0 WHERE greened_on is not null";
		$this->query($q);
		
	}

	function monthlyClosing($on_date,$calculate_loyalty=false){
		if(!$on_date) $on_date = $this->app->now;
		$this->weeklyClosing($on_date);
		// add re-purchase bonus & generation income to this payout rows
		// update distributor with A/B legs from bv table ((max) & (All-max))
		$q="UPDATE 
				mlm_payout p
				JOIN mlm_distributor d on p.distributor_id = d.distributor_id
			SET 
				generation_a_business = IFNULL((select max(bv_sum) from mlm_generation_business bv_table where bv_table.distributor_id = p.distributor_id ),0),
				generation_b_business = IFNULL(((select sum(bv_sum) from mlm_generation_business bv_table where bv_table.distributor_id = d.distributor_id ) - (select max(bv_sum) from mlm_generation_business bv_table where bv_table.distributor_id = d.distributor_id )),0),
				actual_generation_a_business = generation_a_business,
				actual_generation_b_business = generation_b_business
			WHERE 
				d.greened_on is not null AND
				closing_date = '$on_date'

				";
		$this->query($q);

		// what if 60% ratio is not maintained ?? 
		// TODO

		// add self bv in weeker leg
		$q="
			UPDATE
				mlm_payout p 
			SET
				generation_a_business = generation_a_business + (IF(generation_a_business <= generation_b_business,month_self_bv,0)),
				generation_b_business = generation_b_business + (IF(generation_b_business <  generation_a_business,month_self_bv,0))
			WHERE
				closing_date = '$on_date'
		";
		$this->query($q);

		// if any leg is above 60% cap it to 60% business

		$q="
			UPDATE
				mlm_payout p
			SET
				generation_a_business = IF(generation_a_business > ((generation_a_business+generation_b_business)*60/100),((generation_a_business+generation_b_business)*60/100),generation_a_business),
				generation_b_business = IF(generation_b_business > ((generation_a_business+generation_b_business)*60/100),((generation_a_business+generation_b_business)*60/100),generation_b_business)
			WHERE
				closing_date='$on_date'
		";
		$this->query($q);


		// update rank 
		// TODO : Do not degrade rank due to this 60:40.. maintain hiegher rank
		$ranks = $this->add('xavoc\mlm\Model_RePurchaseBonusSlab');

		foreach ($ranks as $row) {
			$q = "
				UPDATE
					mlm_payout p
					JOIN mlm_distributor d on p.distributor_id = d.distributor_id
				SET 
					p.rank = (select name from mlm_re_purchase_bonus_slab WHERE p.month_self_bv+p.generation_a_business+p.generation_b_business > from_bv AND p.month_self_bv+p.generation_a_business+p.generation_b_business <= to_bv),
					p.slab_percentage = IFNULL((select slab_percentage from mlm_re_purchase_bonus_slab WHERE p.month_self_bv+p.generation_a_business+p.generation_b_business > from_bv AND p.month_self_bv+p.generation_a_business+p.generation_b_business <= to_bv),0),
					d.current_rank = p.rank
				WHERE
					closing_date = '$on_date'
			";

			$this->query($q);
		}

		// generate commission as per slab
		$q="
			UPDATE 
				mlm_payout
			SET 
				re_purchase_income_gross = (month_self_bv + generation_a_business+ generation_b_business)* slab_percentage/100
			WHERE
				closing_date = '$on_date'

		";
		$this->query($q);


		// find difference from introducer downline path
		$q="
			UPDATE
				mlm_payout p 
				JOIN mlm_distributor d on p.distributor_id=d.distributor_id
			SET
				p.repurchase_bonus = 
									p.re_purchase_income_gross 
										- 
									IFNULL((
										SELECT 
											SUM(re_purchase_income_gross)
										FROM 
											(select * from mlm_payout where closing_date = '$on_date' ) intros_payout 
										JOIN mlm_distributor intros  on intros.distributor_id = intros_payout.distributor_id
										WHERE
											intros.introducer_id = d.distributor_id 
									),0)
			WHERE
				closing_date = '$on_date'
		";

		$this->query($q);

		// Generation Income
		$this->query('UPDATE mlm_distributor SET temp=0');
		$this->query("UPDATE mlm_distributor d JOIN mlm_payout p  ON d.distributor_id = p.distributor_id SET d.temp=p.repurchase_bonus WHERE p.closing_date='$on_date'");

		$slabs = $this->add('xavoc\mlm\Model_GenerationIncomeSlab');
		foreach ($slabs as $row) {
			
			$field='generation_';
			$rank=$row['name'];
			
			for($i=1;$i<=7;$i++){
				$ques="";
				$ques = str_pad($ques, $i,'_');
				$per = $row[$field.$i];
				if($row[$field.$i]>0){
					$q="
						UPDATE 
							mlm_payout p
						JOIN mlm_distributor d on p.distributor_id=d.distributor_id
						SET
							generation_income_$i = 
												IFNULL((
													SELECT 
														SUM(temp) as repurchase_bonus 
													FROM
														mlm_distributor intros 
													WHERE
														intros.introducer_path like CONCAT(d.path,'$ques')
												)*$per/100,0)
						WHERE
							p.rank = '$rank' AND
							closing_date='$on_date'
					";
					// echo $q.'<br/>';
					$this->query($q);
					
				}
			}
		}

		// sum of generation_income
		$q="
			UPDATE
				mlm_payout
			SET
				generation_income = generation_income_1 + generation_income_2 + generation_income_3 + generation_income_4 + generation_income_5 + generation_income_6 + generation_income_7
			WHERE
				closing_date='$on_date'
		";

		$this->query('UPDATE mlm_distributor SET temp=0');

		// calculate loyalty bonus
		$q="SELECT SUM(month_self_bv) bv_sum FROM mlm_distributor";
		$company_turnover = $this->app->db->dsql()->expr($q)->getHash();
		$company_turnover = $company_turnover['bv_sum'];

		if($calculate_loyalty){
			
			$slabs = $this->add('xavoc\mlm\Model_LoyaltiBonusSlab');
			foreach ($slabs as $row) {
				$rank = $row['name'];
				$turnover_criteria = $row['turnover_criteria'];
				$distributable_amount = $row['distribution_percentage'] * $company_turnover /100;

				$q="SELECT SUM(quarter_bv_saved) quarter_bv_sum FROM mlm_distributor WHERE rank= '$rank' AND quarter_bv_saved > $turnover_criteria";
				$loyalti_level_bv_sum = $this->app->db->dsql()->expr($q)->getHash();
				$loyalti_level_bv_sum = $loyalti_level_bv_sum['quarter_bv_sum'];

				$q="
					UPDATE
						mlm_payout p 
					JOIN mlm_distributor d on p.distributor_id = d.distributor_id
					SET
						p.loyalty_bonus = $distributable_amount * d.quarter_bv_saved / $loyalti_level_bv_sum
					WHERE
						rank= '$rank' AND 
						quarter_bv_saved > $turnover_criteria AND
						closing_date = '$on_date'
				";
				$this->query($q);
				
			}

			// set quarter bv value to zero 
			$q="UPDATE mlm_distributor SET quarter_bv_saved=0";
			$this->query($q);

		}

		// calculate leadership bonus
		
		// save total amount of income other then leadership bonus to distributor temp
		$q="UPDATE mlm_distributor SET temp=0;";
		$this->query($q);
		$q="UPDATE 
				mlm_distributor d
			JOIN mlm_payout p  on p.distributor_id = d.distributor_id
			SET
				d.temp = p.previous_carried_amount + p.binary_income + p.introduction_amount + p.retail_profit + p.repurchase_bonus + p.generation_income + p.loyalty_bonus
			WHERE
				p.closing_date='$on_date'
			";
		$this->query($q);


		$q="
			UPDATE
				mlm_payout p 
			SET
				p.leadership_bonus = IFNULL((SELECT sum(d.temp) from mlm_distributor d WHERE d.introducer_id = p.distributor_id),0)*10/100
			WHERE
				p.closing_date='$on_date';

		";
		$this->query($q);

		// Awards & Rewards
		// Need clear picture to write code

	}

	// $this->addField('gross_payment')->type('datetime');
	// $this->addField('tds')->type('datetime');
	// $this->addField('net_payment')->type('datetime');
	// $this->addField('carried_amount')->type('datetime');

	function calculatePayment($on_date=null){
		if(!$on_date) $on_date = $this->app->now;
		// calculate payment tds deduction carry forward etc. inclusing previous carried amount
		// set and save carried_amount to distributor

		$q="UPDATE mlm_payout SET gross_payment = previous_carried_amount + binary_income + introduction_amount + retail_profit + repurchase_bonus + generation_income + loyalty_bonus + leadership_bonus   WHERE closing_date='$on_date'";
		$this->query($q);


		// Carry forward condition ..

		// non green not in payout but how to carry paris
		// non min purchase persons amount or min payout amount to carryied .. make tds admin etc zero 
		// put this in distributor carried amount field

	}

	function resetWeekData(){
		// set fields zero in distributor 
		// like month_self_bv if greened_on is not null

	}

	function resetMonthData(){
		// set fields zero in distributor 
		// like month_self_bv if greened_on is not null

	}

	function doClosing($type='daily',$on_date=null, $calculate_loyalty=false){

		if(!$on_date) $on_date = $this->app->now;
		switch ($type) {
			case 'daily':
				$this->dailyClosing($on_date);
				break;
			case 'weekly':
				$this->weeklyClosing($on_date);
				$this->calculatePayment($on_date);
				$this->resetWeekData();
				break;
			case 'monthly':
				$this->monthlyClosing($on_date,$calculate_loyalty);
				$this->calculatePayment($on_date);
				$this->resetMonthData();
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