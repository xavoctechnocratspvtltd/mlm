<?php

namespace xavoc\mlm;

class Model_Closing extends \xepan\base\Model_Table {
	public $table ="mlm_closing";

	public $status = ['All'];

	public $actions = [
		'All'=>['view','edit','delete','payoutsheet']
	];

	public $acl_type = 'Closing';
	
	function init(){
		parent::init();

		$this->addExpression('status','"All"');

		$this->addField('on_date')->type('datetime')->defaultValue($this->app->now);
		$this->addField('calculate_loyalty')->type('boolean')->defaultValue(false);
		$this->addField('type')->enum(['WeeklyClosing','MonthlyClosing']);
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
				day_pairs = day_pairs*10/100,
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
				SELECT 	  0,$closing_id,distributor_id,'$on_date'  ,carried_amount         , week_pairs   , weekly_intros_amount,      0       ,          0    ,month_self_bv,      0          ,       0     ,     0       , 0 ,     0      ,        0       FROM mlm_distributor 
		";
				// WHERE greened_on is not null

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

		// retail_profit 

		$q="
			UPDATE
				mlm_payout p
			JOIN mlm_distributor d on p.distributor_id=d.distributor_id
			SET
				p.retail_profit = d.monthly_retail_profie
			WHERE
				p.closing_date = '$on_date'
		";
		$this->query($q);

		// reset in distributor table
		$q="UPDATE mlm_distributor SET monthly_retail_profie=0";
		$this->query($q);


		// update month generation bv = sum(month_bv) of my intros
		$q="
			UPDATE mlm_payout p
			SET
				p.generation_month_business = IFNULL((SELECT SUM(month_bv) FROM  mlm_distributor d WHERE p.distributor_id = d.introducer_id),0)
											+
											IFNULL((SELECT month_self_bv FROM mlm_distributor d WHERE d.distributor_id=p.distributor_id) ,0)
											,
				p.generation_total_business = IFNULL((SELECT SUM(total_month_bv) FROM  mlm_distributor d WHERE p.distributor_id = d.introducer_id),0)
											+
											IFNULL((SELECT total_self_bv FROM mlm_distributor d WHERE d.distributor_id=p.distributor_id) ,0)
											,
				p.capped_total_business = 	IFNULL((SELECT SUM(total_month_bv) FROM  mlm_distributor d WHERE p.distributor_id = d.introducer_id),0)
											+
											IFNULL((SELECT total_self_bv FROM mlm_distributor d WHERE d.distributor_id=p.distributor_id) ,0)
			WHERE
				p.closing_date='$on_date';
		";
		$this->query($q);

		$debug_60_40=false;

		// use of tempp to check if some rank is already failed
		$this->query('UPDATE mlm_distributor SET temp=0');

		$ranks = $this->add('xavoc\mlm\Model_RePurchaseBonusSlab');
		$previous_rank=0;
		foreach ($ranks as $row) {
			$rank_id = $row->id;
			$rank_name = $row['name'];
			$rank_slab_percentage = $row['slab_percentage'];
			$rank_from_bv = $row['from_bv'];
			// try to get next rank first
			$next_rank = $this->add('xavoc\mlm\Model_RePurchaseBonusSlab');
			$next_rank->addCondition('slab_percentage','>',$row['slab_percentage']);
			$next_rank->tryLoadAny();
			if($debug_60_40) echo "checking $rank_name ($rank_id) - $rank_slab_percentage % <br/>";
			if($debug_60_40) echo $next_rank['slab_percentage'].'<br/>';
			// if next rank available 
			if($next_rank->loaded() && $next_rank['required_60_percentage'] && $this->app->getConfig('include_60_40',true)){
				// set capped_month_business = sum(monthbv/nextslab_target*.6 whicever is lesser)
				if($debug_60_40) echo "in capping test</br/>";
				$next_target = $next_rank['from_bv']*0.6;
				$next_from = $next_rank['from_bv'];
				$next_to = $next_rank['to_bv'];
				$q="
					UPDATE
						mlm_payout p
					JOIN mlm_distributor d on p.distributor_id=d.distributor_id
					SET
						p.capped_total_business = IFNULL((SELECT SUM(IF(total_month_bv<$next_target,total_month_bv,$next_target)) FROM  mlm_distributor d WHERE p.distributor_id = d.introducer_id),0)
						+ IFNULL(d.total_self_bv,0)
					WHERE
						d.current_rank_id = $previous_rank AND
						p.capped_total_business >= $rank_from_bv AND
						p.closing_date='$on_date';
				";

				if($debug_60_40) echo $q .'<br/>';

				$this->query($q);
			}

			$q = "
				UPDATE
					mlm_payout p
					JOIN mlm_distributor d on p.distributor_id = d.distributor_id
				SET 
					p.rank = '$rank_name',
					p.slab_percentage = $rank_slab_percentage,
					d.current_rank_id = $rank_id
				WHERE
					p.capped_total_business >= $rank_from_bv AND
					closing_date = '$on_date'
				";
			if($debug_60_40) echo $q.'<br/>';

			$this->query($q);

			$previous_rank= $rank_id;
		}
		
		// if($debug_60_40) exit;


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
			$q="UPDATE mlm_distributor SET month_bv=0";
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

		// make negative difference to zero ??? Is this okay.. I doubt
		// but doing as company said .. but this is totally looks business of loss
		if($this->app->getConfig('make_negative_difference_to_zero',true)){
			$q="
				UPDATE
					mlm_payout
				SET
					repurchase_bonus=0
				WHERE
					repurchase_bonus < 0 AND
					closing_date = '$on_date'
			";
			$this->query($q);
		}

		if(!$this->app->getConfig('skipzero_for_testing',false)){
			// Generation Income
			$this->query('UPDATE mlm_distributor SET temp=0');
			$this->query("UPDATE mlm_distributor d JOIN mlm_payout p  ON d.distributor_id = p.distributor_id SET d.temp=p.repurchase_bonus WHERE p.closing_date='$on_date'");
		}


		/*
		SELECT 
p.distributor_id,
(	select 
		sum(repurchase_bonus) 
	from (select * from mlm_payout) pi 
	join mlm_distributor d1 on pi.distributor_id=d1.distributor_id
	join mlm_distributor d2 on d1.introducer_id = d2.distributor_id
-- 	join mlm_distributor d3 on d2.introducer_id = d1.distributor_id
	where d2.introducer_id = d.distributor_id
)

from 
	mlm_payout p
	JOIN mlm_distributor d on p.distributor_id=d.distributor_id
WHERE
	
	d.current_rank_id >= 30
AND	p.closing_date = "2017-05-18 00:00:00"	

		*/
		$slabs = $this->add('xavoc\mlm\Model_GenerationIncomeSlab');
		foreach ($slabs as $row) {
			
			$field='generation_';
			$rank=$row['name'];
			$rank_id= $row['rank_id'];
			
			for($i=1;$i<=7;$i++){
				$ques="";
				$per = $row[$field.$i];
				if($row[$field.$i]>0){
					$q="
						UPDATE 
						mlm_payout p
					JOIN mlm_distributor d on p.distributor_id= d.distributor_id
					SET
					p.generation_income_$i = 
						(	
						SELECT 
							IFNULL(sum(repurchase_bonus)*$per/100 ,0)
						FROM (select * from mlm_payout) pi
						JOIN mlm_distributor d1 on pi.distributor_id=d1.distributor_id
						"; 
						for ($j=2; $j <= $i; $j++) { 
							$q.=(" join mlm_distributor d$j on d$j.distributor_id=d".($j-1).".introducer_id ");
						}
						$q.="
							where d$i.introducer_id = d.distributor_id
						)
						WHERE
							d.current_rank_id = $rank_id
							AND	p.closing_date = '$on_date'	
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
				p.carried_amount = gross_payment,
				tds=0,
				admin_charge=0,
				net_payment = 0
			WHERE
				(
					p.month_self_bv < 500 OR
					net_payment < 500 OR
					d.is_document_verified = 0 OR
					d.is_document_verified is null
				) AND

				closing_date='$on_date'
		";
		$this->query($q);

		// add this carried amount in distributor for previous_carried_amount for next closing
		if($this->app->getConfig('remove_zero_income',true)){
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
		}

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
