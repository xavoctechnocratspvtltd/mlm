<?php

namespace xavoc\mlm;

class Model_Closing extends \xepan\hr\Model_Document {
	
	public $status = ['All'];

	public $actions = [
		'All'=>['view','edit','delete','payoutsheet']
	];

	public $acl_type = 'Closing';
	
	function init(){
		parent::init();

		$this->getElement('status')->defaultValue('All');

		$cls_j = $this->join('mlm_closing.closing_id');
		$cls_j->addField('on_date')->type('datetime')->defaultValue($this->app->now);
		$cls_j->addField('calculate_loyalty')->type('boolean')->defaultValue(false);
		$this->getElement('type')->enum(['WeeklyClosing','MonthlyClosing']);
		$this->hasMany('xavoc\mlm\Payout','closing_id');

		$this->is([
				'on_date|unique|required',
				'type|required'
			]);
		$this->addHook('beforeSave',$this);
		$this->addHook('afterInsert',$this);


	}

	function beforeSave(){
		$back_date_closing = $this->add('xavoc\mlm\Model_Closing');
		$back_date_closing->addCondition('on_date','>=',$this['on_date']);
		$back_date_closing->tryLoadAny();

		if($back_date_closing->loaded()){
			throw $this->exception('Closing already done after/on this date','ValidityCheck')->setField('on_date');
		}
	}

	function afterInsert($m,$new_id){
		$this->load($new_id);
		if($this['type']=='WeeklyClosing' AND $this['calculate_loyalty']){
			throw $this->exception('Loyalty cannot be calculated on weekly closing','ValidityCheck')->setField('calculate_loyalty');
		}

		switch ($this['type']) {
			case 'WeeklyClosing':
				$this->weeklyClosing($this->id,$this['on_date']);
				$this->calculatePayment($this['on_date']);
				$this->resetWeekData($this['on_date']);
				break;

			case 'MonthlyClosing':
				$this->monthlyClosing($this->id,$this['on_date'],$this['calculate_loyalty']);
				$this->calculatePayment($this['on_date']);
				$this->resetMonthData($this['on_date']);
				break;
			
			default:
				
				break;
		}
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

	function weeklyClosing($closing_id,$on_date){
		if(!$on_date) $on_date = $this->app->now;
		$this->dailyClosing($on_date);
		// move data to payout table

		// copy all distributors in here
		$q="
			INSERT INTO mlm_payout
						(id, closing_id, distributor_id,closing_date,previous_carried_amount, binary_income, introduction_amount, retail_profit,slab_percentage,month_self_bv,generation_income,loyalty_bonus,gross_payment,tds, net_payment,  carried_amount)
				SELECT 	  0,$closing_id,distributor_id,'$on_date'  ,carried_amount         , week_pairs   , weekly_intros_amount,         0   ,          0    ,month_self_bv,      0          ,       0     ,     0       , 0 ,     0      ,        0       FROM mlm_distributor WHERE greened_on is not null
		";
		$this->query($q);

		// make weekly figures zero
		if(!$this->app->getConfig('skipzero_for_testing',false)){
			$q="UPDATE mlm_distributor SET week_pairs=0, weekly_intros_amount=0 WHERE greened_on is not null";
			$this->query($q);
		}
		
	}

	function monthlyClosing($closing_id,$on_date,$calculate_loyalty=false){
		if(!$on_date) $on_date = $this->app->now;
		$this->weeklyClosing($closing_id,$on_date);
		// add re-purchase bonus & generation income to this payout rows
		// update distributor with A/B legs from bv table ((max) & (All-max))
		$q="UPDATE 
				mlm_payout p
				JOIN mlm_distributor d on p.distributor_id = d.distributor_id
			SET 
				generation_a_business = IFNULL((select max(bv_sum) from mlm_generation_business bv_table where bv_table.distributor_id = p.distributor_id ),0),
				generation_b_business = IFNULL(((select sum(bv_sum) from mlm_generation_business bv_table where bv_table.distributor_id = d.distributor_id ) - (select max(bv_sum) from mlm_generation_business bv_table where bv_table.distributor_id = d.distributor_id )),0),
				generation_month_business = IFNULL((SELECT sum(month_bv) from mlm_generation_business bv_table WHERE bv_table.distributor_id = d.distributor_id)  ,0) + IFNULL(d.month_self_bv,0)
			WHERE 
				d.greened_on is not null AND
				closing_date = '$on_date'

				";
		$this->query($q);

		// save actual business before 60-40 and adding self bv in weeker leg

			
			$q="UPDATE 
					mlm_payout p
				SET 
					actual_generation_a_business = generation_a_business,
					actual_generation_b_business = generation_b_business
				WHERE 
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
				generation_a_business = generation_a_business + (IF(generation_a_business <= generation_b_business AND generation_b_business > 0 ,month_self_bv,0)),
				generation_b_business = generation_b_business + (IF(generation_b_business <  generation_a_business,month_self_bv,0))
			WHERE
				closing_date = '$on_date'
		";
		$this->query($q);

		// if any leg is above 60% cap it to 60% business

		if($this->app->getConfig('include_60_40',true)){
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
		}

		// update rank 
		// TODO : Do not degrade rank due to this 60:40.. maintain hiegher rank
		$ranks = $this->add('xavoc\mlm\Model_RePurchaseBonusSlab');

		foreach ($ranks as $row) {
			$rank_id = $row->id;
			$q = "
				UPDATE
					mlm_payout p
					JOIN mlm_distributor d on p.distributor_id = d.distributor_id
				SET 
					p.rank = (select name from mlm_re_purchase_bonus_slab WHERE p.generation_month_business > from_bv AND p.generation_month_business <= to_bv),
					p.slab_percentage = IFNULL((select slab_percentage from mlm_re_purchase_bonus_slab WHERE p.generation_month_business > from_bv AND p.generation_month_business <= to_bv),0),
					d.current_rank = p.rank,
					d.current_rank_id = (select id from mlm_re_purchase_bonus_slab WHERE p.generation_month_business > from_bv AND p.generation_month_business <= to_bv)
				WHERE
					(d.current_rank_id < $rank_id OR d.current_rank_id is null) AND
					closing_date = '$on_date'
			";

			$this->query($q);
		}

		// generate commission as per slab
		$q="
			UPDATE 
				mlm_payout
			SET 
				re_purchase_income_gross = (generation_month_business)* slab_percentage/100
			WHERE
				closing_date = '$on_date'

		";
		$this->query($q);

		if(!$this->app->getConfig('skipzero_for_testing',false)){
			// set month bv =0
			$q="UPDATE mlm_generation_business SET month_bv=0";
			$this->query($q);

			$q="UPDATE mlm_distributor SET month_self_bv=0";
			$this->query($q);
		}

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

		if(!$this->app->getConfig('skipzero_for_testing',false)){
			// Generation Income
			$this->query('UPDATE mlm_distributor SET temp=0');
			$this->query("UPDATE mlm_distributor d JOIN mlm_payout p  ON d.distributor_id = p.distributor_id SET d.temp=p.repurchase_bonus WHERE p.closing_date='$on_date'");
		}

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

			if(!$this->app->getConfig('skipzero_for_testing',false)){
				// set quarter bv value to zero 
				$q="UPDATE mlm_distributor SET quarter_bv_saved=0";
				$this->query($q);
			}

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

		$q="
			UPDATE
				mlm_payout p
			JOIN mlm_distributor d on p.distributor_id=d.distributor_id
			SET 
				gross_payment = previous_carried_amount + binary_income + introduction_amount + retail_profit + repurchase_bonus + generation_income + loyalty_bonus + leadership_bonus
			WHERE closing_date='$on_date'";
		$this->query($q);

		// set tds and admin
		$q="
			UPDATE
				mlm_payout p
			JOIN mlm_distributor d on p.distributor_id=d.distributor_id
			JOIN customer c on c.contact_id = d.distributor_id
			SET 
				tds = IF(c.pan_no <> '' AND c.pan_no is not null,gross_payment*5/100,gross_payment*20/100),
				admin_charge = gross_payment*5/100
			WHERE closing_date='$on_date'";
		$this->query($q);

		// set net amount
		$q="
			UPDATE
				mlm_payout p
			JOIN mlm_distributor d on p.distributor_id=d.distributor_id
			JOIN customer c on c.contact_id = d.distributor_id
			SET 
				net_payment = gross_payment - ( tds + admin_charge )
			WHERE closing_date='$on_date'";
		$this->query($q);


		// Carry forward condition ..
		// TODO min self purchase and payout from config

		$q="
			UPDATE
				mlm_payout p
				JOIN mlm_distributor d on p.distributor_id=d.distributor_id
			SET
				carried_amount = gross_payment,
				tds=0,
				admin_charge=0,
				net_payment = 0
			WHERE
				(
					month_self_bv < 500 OR
					net_payment < 500 OR
					d.is_document_verified = 0
				) AND

				closing_date='$on_date'
		";
		$this->query($q);

		// add this carried amount in distributor for previous_carried_amount for next closing
		$q="
			UPDATE
				mlm_distributor d
			JOIN mlm_payout p on d.distributor_id = p.distributor_id
			SET
				d.carried_amount = d.carried_amount + p.carried_amount
			WHERE
				p.carried_amount is not null AND 
				p.carried_amount > 0 AND
				p.closing_date='$on_date'
		";
		$this->query($q);

		// non green not in payout but how to carry paris
		// non min purchase persons amount or min payout amount to carryied .. make tds admin etc zero 
		// put this in distributor carried amount field

	}

	function resetWeekData($on_date=null){
		if(!$on_date) $on_date = $this->app->today;
		// set fields zero in distributor 
		$q="
			DELETE FROM mlm_payout WHERE closing_date='$on_date' AND net_payment=0 AND carried_amount=0
		";
		$this->query($q);

	}

	function resetMonthData($on_date=null){
		if(!$on_date) $on_date = $this->app->today;
		// set fields zero in distributor 
		// like month_self_bv if greened_on is not null
		$this->resetWeekData($on_date);
		
	}

	function doClosing($type='daily',$on_date=null, $calculate_loyalty=false){

		if(!$on_date) $on_date = $this->app->now;

		// if($type !== 'daily'){
		// 	// save this closing row first
		// 	$this['type']=ucwords($type).'Closing';
		// 	$this['on_date'] = $on_date;
		// 	$this['calculate_loyalty'] = $calculate_loyalty;
		// 	$this->save();
		// }

		switch ($type) {
			case 'daily':
				$this->dailyClosing($on_date);
				break;
			case 'weekly':
				$this->weeklyClosing($this->id,$this['on_date']);
				$this->calculatePayment($this['on_date']);
				$this->resetWeekData($this['on_date']);
				break;
			case 'monthly':
				$this->monthlyClosing($this->id,$this['on_date'],$this['calculate_loyalty']);
				$this->calculatePayment($this['on_date']);
				$this->resetMonthData($this['on_date']);
				break;
			default:
				throw new \Exception("$type type closing not available", 1);				
				break;
		}
	}

	function query($q){
		$this->api->db->dsql($this->api->db->dsql()->expr($q))->execute();
	}

	function payoutsheet(){
		$this->app->redirect($this->app->url('xavoc_dm_payout',['closing_id'=>$this->id]));
	}
}


// payout view
// select `contact`.`first_name` AS `first_name`,`mlm_payout`.`id` AS `id`,`mlm_payout`.`distributor_id` AS `distributor_id`,`mlm_payout`.`closing_date` AS `closing_date`,`mlm_payout`.`previous_carried_amount` AS `previous_carried_amount`,`mlm_payout`.`binary_income` AS `binary_income`,`mlm_payout`.`introduction_amount` AS `introduction_amount`,`mlm_payout`.`retail_profit` AS `retail_profit`,`mlm_payout`.`rank` AS `rank`,`mlm_payout`.`month_self_bv` AS `month_self_bv`,`mlm_payout`.`slab_percentage` AS `slab_percentage`,`mlm_payout`.`actual_generation_a_business` AS `actual_generation_a_business`,`mlm_payout`.`actual_generation_b_business` AS `actual_generation_b_business`,`mlm_payout`.`generation_a_business` AS `generation_a_business`,`mlm_payout`.`generation_b_business` AS `generation_b_business`,`mlm_payout`.`generation_month_business` AS `generation_month_business`,`mlm_payout`.`re_purchase_income_gross` AS `re_purchase_incomce_gross`,`mlm_payout`.`repurchase_bonus` AS `repurchase_bonus`,`mlm_payout`.`generation_income_1` AS `generation_income_1`,`mlm_payout`.`generation_income_2` AS `generation_income_2`,`mlm_payout`.`generation_income_3` AS `generation_income_3`,`mlm_payout`.`generation_income_4` AS `generation_income_4`,`mlm_payout`.`generation_income_5` AS `generation_income_5`,`mlm_payout`.`generation_income_6` AS `generation_income_6`,`mlm_payout`.`generation_income_7` AS `generation_income_7`,`mlm_payout`.`generation_income` AS `generation_income`,`mlm_payout`.`loyalty_bonus` AS `loyalty_bonus`,`mlm_payout`.`leadership_bonus` AS `leadership_bonus`,`mlm_payout`.`gross_payment` AS `gross_payment`,`mlm_payout`.`tds` AS `tds`,`mlm_payout`.`admin_charge` AS `admin_charge`,`mlm_payout`.`net_payment` AS `net_payment`,`mlm_payout`.`carried_amount` AS `carried_amount`,`user`.`username` AS `username` from (((`mlm_distributor` join `mlm_payout` on((`mlm_distributor`.`distributor_id` = `mlm_payout`.`distributor_id`))) join `contact` on((`mlm_distributor`.`distributor_id` = `contact`.`id`))) join `user` on((`contact`.`user_id` = `user`.`id`)))