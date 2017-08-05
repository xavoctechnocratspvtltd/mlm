<?php

namespace xavoc\mlm;

class Model_Closing extends \xepan\base\Model_Table {
	public $table ="mlm_closing";

	public $status = ['All'];

	public $actions = [
		'All'=>['view','edit','delete','payoutsheet']
	];

	public $acl_type = 'Closing';

	public $generation_bonus=[];

	
	function init(){
		parent::init();

		$this->addExpression('status','"All"');

		$this->addField('on_date')->type('datetime')->defaultValue($this->app->now);
		$this->addField('calculate_loyalty')->type('boolean')->defaultValue(false);
		$this->addField('type')->enum(['DailyClosing','WeeklyClosing','MonthlyClosing']);
		$this->hasMany('xavoc\mlm\Payout','closing_id');

		$this->is([
				'on_date|unique|required',
				'type|required'
			]);
		$this->addHook('beforeSave',$this);
		$this->addHook('afterInsert',$this);


	}

	function beforeSave(){

		if(!$this->app->getConfig('enable_closing',false)){
			throw new \Exception("Closing is disabled for safty reasons", 1);
			
		}

		// take backup by shell command ???
		// check varius conditions like
		// 1. for monthly and weekly there must be a daily closing before on same? day 
		// 2. there must not be two closings of same type on same day
		// 

		$back_date_closing = $this->add('xavoc\mlm\Model_Closing');
		$back_date_closing->addCondition('on_date','>=',$this['on_date']);
		$back_date_closing->addCondition('type',$this['type']);
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
			case 'DailyClosing':			
				$this->dailyClosing($this['on_date']);
				break;
			case 'WeeklyClosing':
				// cehck if daily is closed before 
				$closing = $this->add('xavoc\mlm\Model_Closing')
                    ->addCondition('type','DailyClosing')
                    ->addCondition('on_date',$this->app->today)
                    ->tryLoadAny();
                if(!$closing->loaded()) throw new \Exception("Daily Closing not run before, please run daily closing first", 1);
                
				$this->weeklyClosing($this->id,$this['on_date']);
				break;
			case 'MonthlyClosing':
				// cehck if daily is closed before 
				$closing = $this->add('xavoc\mlm\Model_Closing')
                    ->addCondition('type','DailyClosing')
                    ->addCondition('on_date',$this->app->today)
                    ->tryLoadAny();
            	if(!$closing->loaded()) throw new \Exception("Daily Closing not run before, please run daily closing first", 1);
				$this->monthlyClosing($this->id,$this['on_date'],$this['calculate_loyalty']);
				break;
			
			default:
				
				break;
		}
	}

	function dailyClosing($on_date){
		if(!$on_date) $on_date = $this->app->now;

		$pair_pv = '1000'; //tail pv
		// $admin_charge = $config['admin_charge'];
		// $min_payout = $config['minimum_payout_amount'];

		//  null may give problem ... remove it
		$this->query("UPDATE mlm_distributor set day_left_sv=0 WHERE day_left_sv is null");
		$this->query("UPDATE mlm_distributor set day_right_sv=0 WHERE day_right_sv is null");

		// calculate Pairs
		$q="
			UPDATE mlm_distributor
			SET
				day_pairs = IF(day_left_sv > day_right_sv, day_right_sv ,day_left_sv ),
				day_pairs = IF(day_left_sv = day_right_sv AND day_left_sv <> 0 AND day_left_sv <= capping, day_pairs - $pair_pv ,day_pairs),
				day_pairs = day_pairs*10/100,
				/* ????????????????????????  */
				day_pairs = IF(day_pairs >= capping, capping, day_pairs),
				week_pairs = week_pairs + day_pairs
			/*WHERE greened_on is not null*/
		";
		$this->query($q);

		// Set Session PV Carry forwards
		$q="
			UPDATE 
				mlm_distributor d
			SET
				d.temp=0,
				d.temp = IF(d.day_left_sv = d.day_right_sv AND d.day_left_sv > 0, d.day_left_sv - $pair_pv, IF(d.day_left_sv > d.day_right_sv,d.day_right_sv,d.day_left_sv)),
				d.day_left_sv = IFNULL(d.day_left_sv - d.temp,0),
				d.day_right_sv = IFNULL(d.day_right_sv - d.temp,0)
			/*WHERE greened_on is not null*/
		";
		$this->query($q);
		
	}


	function weeklyClosing($closing_id,$on_date){
		if(!$on_date) $on_date = $this->app->now;
		// move data to payout table
		if(date('w', strtotime($on_date)) !== '0'){
			throw new \Exception("Weekly closing must be on sunday (0) 00:00 After Saturday Finished. Today is " . date('w', strtotime($on_date)), 1);
		}

		// copy all distributors in here
		$q="
			INSERT INTO mlm_payout
						(id, closing_id, distributor_id,sponsor_id, introducer_id,closing_date,previous_carried_amount, binary_income, introduction_amount, retail_profit,slab_percentage,month_self_bv,generation_income,loyalty_bonus,gross_payment,tds, net_payment,  carried_amount, saved_monthly_green_intros, saved_weekly_intros_amount, saved_total_intros_amount, saved_day_left_sv, saved_day_right_sv, saved_day_pairs, saved_week_pairs, saved_total_left_sv, saved_total_right_sv, saved_month_self_bv, saved_total_self_bv, saved_month_bv, saved_total_month_bv, saved_quarter_bv_saved, saved_monthly_retail_profie, saved_total_pairs)
				SELECT 	  0,$closing_id,distributor_id, sponsor_id, introducer_id,'$on_date'  ,carried_amount         , week_pairs   , weekly_intros_amount,      0       ,          0    ,     0      ,      0          ,       0     ,     0       , 0 ,     0      ,        0       , monthly_green_intros, weekly_intros_amount, total_intros_amount, day_left_sv, day_right_sv, day_pairs, week_pairs, total_left_sv, total_right_sv, month_self_bv, total_self_bv, month_bv, total_month_bv, quarter_bv_saved, monthly_retail_profie, total_pairs FROM mlm_distributor 
		";
				// WHERE greened_on is not null

		$this->query($q);

		// calculate leadership bonus
		
		// save total amount of income other then leadership bonus to distributor temp
		$q="UPDATE mlm_distributor SET temp=0;";
		$this->query($q);
		$q="UPDATE 
				mlm_distributor d
			JOIN mlm_payout p  on p.distributor_id = d.distributor_id
			SET
				d.temp = p.binary_income + p.introduction_amount + p.retail_profit + p.repurchase_bonus + p.generation_income + p.loyalty_bonus
			WHERE
				p.closing_id=$closing_id
			";
		$this->query($q);


		$q="
			UPDATE
				mlm_payout p 
			SET
				p.leadership_bonus = IFNULL((SELECT sum(d.temp) from mlm_distributor d WHERE d.introducer_id = p.distributor_id),0)*10/100
			WHERE
				p.closing_id=$closing_id;

		";
		$this->query($q);

		// save this leadership bonus to be added in monthly closing
		// Keep adding for all binary closings before monthly closing
		$q="
			UPDATE 
				mlm_distributor d
				JOIN mlm_payout p on d.distributor_id=p.distributor_id
			SET
				d.leadership_carried_amount = d.leadership_carried_amount + p.leadership_bonus 
			WHERE
				p.closing_id=$closing_id
		";
		$this->query($q);

		// and make this leadership bonus zero here, we are not gonna give it now
		$q="
			UPDATE
				mlm_payout p
			SET 
				p.leadership_bonus=0
			WHERE
				p.closing_id=$closing_id
		";
		$this->query($q);

		// make weekly figures zero
		if(!$this->app->getConfig('skipzero_for_testing',false)){
			$q="UPDATE mlm_distributor SET week_pairs=0, weekly_intros_amount=0 WHERE greened_on is not null";
			$this->query($q);
		}

		$this->calculateWeeklyPayment($this['on_date'],$closing_id);
		$this->resetWeekData($this['on_date'],$closing_id);
		
	}

	function calculateWeeklyPayment($on_date=null,$closing_id){
		if(!$on_date) $on_date = $this->app->now;
		// calculate payment tds deduction carry forward etc. inclusing previous carried amount
		// set and save carried_amount to distributor

		$q="
			UPDATE
				mlm_payout p
			JOIN mlm_distributor d on p.distributor_id=d.distributor_id
			SET 
				gross_payment = previous_carried_amount + binary_income + introduction_amount + retail_profit + repurchase_bonus + generation_income + loyalty_bonus + leadership_bonus
			WHERE closing_id=$closing_id";
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
			WHERE closing_id=$closing_id";
		$this->query($q);

		// set net amount
		$q="
			UPDATE
				mlm_payout p
			JOIN mlm_distributor d on p.distributor_id=d.distributor_id
			JOIN customer c on c.contact_id = d.distributor_id
			SET 
				net_payment = gross_payment - ( tds + admin_charge )
			WHERE closing_id=$closing_id";
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
					/* ???????????????????????? */
					/*p.month_self_bv < 250 OR*/
					net_payment < 500 /*OR
					d.is_document_verified = 0 OR
					d.is_document_verified is null*/
					/*
					OR (select count(distributor_id) from mlm_distributor li where li.introducer_id = d.distributor_id and li.path like concat(d.path,'A%')) < 1
					OR (select count(distributor_id) from mlm_distributor ri where ri.introducer_id = d.distributor_id and ri.path like concat(d.path,'B%')) < 1
					*/
				) AND

				closing_id=$closing_id
		";
		$this->query($q);

		// add this carried amount in distributor for previous_carried_amount for next closing
		$q="
			UPDATE
				mlm_distributor d
			JOIN mlm_payout p on d.distributor_id = p.distributor_id
			SET
				d.carried_amount = p.carried_amount
			WHERE
				p.carried_amount is not null AND 
				p.carried_amount > 0 AND
				p.closing_id=$closing_id
		";
		$this->query($q);

		if($this->app->getConfig('remove_zero_income',true)){
			$q="
				DELETE p
					FROM
					mlm_payout p
				WHERE
					p.closing_id=$closing_id AND 
					p.net_payment = 0 and 
					p.carried_amount = 0
			";

			$this->query($q);
		}

		// non green not in payout but how to carry paris
		// non min purchase persons amount or min payout amount to carryied .. make tds admin etc zero 
		// put this in distributor carried amount field

	}

	function monthlyClosing($closing_id,$on_date,$calculate_loyalty=false){
		if(!$on_date) $on_date = $this->app->now;

		if(date('d', strtotime($on_date)) !== '05'){
			throw new \Exception("Monthly closing must be on 01st of month 00:00 After Previous Month Finished", 1);
		}

		// copy all distributors in here
		$q="
			INSERT INTO mlm_payout
						(id, closing_id, distributor_id,sponsor_id, introducer_id,closing_date,previous_carried_amount, binary_income, introduction_amount, retail_profit,slab_percentage,month_self_bv,generation_income,loyalty_bonus,gross_payment,tds, net_payment,  carried_amount, saved_monthly_green_intros, saved_weekly_intros_amount, saved_total_intros_amount, saved_day_left_sv, saved_day_right_sv, saved_day_pairs, saved_week_pairs, saved_total_left_sv, saved_total_right_sv, saved_month_self_bv, saved_total_self_bv, saved_month_bv, saved_total_month_bv, saved_quarter_bv_saved, saved_monthly_retail_profie, saved_total_pairs)
				SELECT 	  0,$closing_id,distributor_id, sponsor_id, introducer_id,'$on_date'  ,carried_amount         , 0            ,         0          ,      0       ,          0    ,month_self_bv,      0          ,       0     ,     0       , 0 ,     0      ,        0       ,  monthly_green_intros, weekly_intros_amount, total_intros_amount, day_left_sv, day_right_sv, day_pairs, week_pairs, total_left_sv, total_right_sv, month_self_bv, total_self_bv, month_bv, total_month_bv, quarter_bv_saved, monthly_retail_profie, total_pairs FROM mlm_distributor 
		";
				// WHERE greened_on is not null

		$this->query($q);

		// retail_profit 

		$q="
			UPDATE
				mlm_payout p
			JOIN mlm_distributor d on p.distributor_id=d.distributor_id
			SET
				p.retail_profit = d.monthly_retail_profie
			WHERE
				p.closing_id=$closing_id
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
				p.closing_id=$closing_id;
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
						p.closing_id=$closing_id;
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
					p.closing_id=$closing_id
				";
			if($debug_60_40) echo $q.'<br/>';

			$this->query($q);

			$previous_rank= $rank_id;
		}

		// ======= new 60-40 based business difference generation generation_bonus

		$q="
			UPDATE 
				mlm_distributor d
				JOIN mlm_payout p on p.distributor_id=d.distributor_id
			SET
				d.temp = p.slab_percentage
			WHERE
				p.closing_id=$closing_id
		";
		$this->query($q);

		$this->query("UPDATE mlm_distributor SET temp2=0");
		$this->setGenerationBonus();
		
		$q="
			UPDATE 
				mlm_payout p
				JOIN mlm_distributor d on p.distributor_id=d.distributor_id
			SET
				p.repurchase_bonus = d.temp2
			WHERE
			p.closing_id=$closing_id
		";
		$this->query($q);

		if(!$this->app->getConfig('skipzero_for_testing',false)){
			// set month bv =0
			$q="UPDATE mlm_distributor SET month_bv=0";
			$this->query($q);

			$q="UPDATE mlm_distributor SET month_self_bv=0";
			$this->query($q);
		}

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
					closing_id=$closing_id
			";
			$this->query($q);
		}

		if(!$this->app->getConfig('skipzero_for_testing',false)){
			// Generation Income
			$this->query('UPDATE mlm_distributor SET temp=0');
			$this->query("UPDATE mlm_distributor d JOIN mlm_payout p  ON d.distributor_id = p.distributor_id SET d.temp=p.repurchase_bonus WHERE p.closing_id=$closing_id");
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
							AND	p.closing_id=$closing_id
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
				closing_id=$closing_id
		";

		$this->query($q);

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
						closing_id=$closing_id
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
				d.temp = p.binary_income + p.introduction_amount + p.retail_profit + p.repurchase_bonus + p.generation_income + p.loyalty_bonus
			WHERE
				p.closing_id=$closing_id
			";
		$this->query($q);


		$q="
			UPDATE
				mlm_payout p 
			SET
				p.leadership_bonus = IFNULL((SELECT sum(d.temp) from mlm_distributor d WHERE d.introducer_id = p.distributor_id),0)*10/100
			WHERE
				p.closing_id=$closing_id;

		";
		$this->query($q);

		// update with leadership bonus commulated in mlm_distributor also
		$q="
			UPDATE
				mlm_payout p 
				JOIN mlm_distributor d on p.distributor_id=d.distributor_id
			SET
				p.leadership_bonus = p.leadership_bonus + d.leadership_carried_amount
			WHERE
				p.closing_id=$closing_id;
		";
		$this->query($q);

		// make leadership_carried_amount in distributor zero .. ready for next binary incomes to add
		$q="UPDATE mlm_distributor SET leadership_carried_amount = 0";
		$this->query($q);

		// Awards & Rewards
		// Need clear picture to write code

		$this->calculateMonthlyPayment($this['on_date'],$closing_id);
		$this->resetMonthData($this['on_date'],$closing_id);

	}

	// $this->addField('gross_payment')->type('datetime');
	// $this->addField('tds')->type('datetime');
	// $this->addField('net_payment')->type('datetime');
	// $this->addField('carried_amount')->type('datetime');

	

	function calculateMonthlyPayment($on_date=null,$closing_id){
		if(!$on_date) $on_date = $this->app->now;
		// calculate payment tds deduction carry forward etc. inclusing previous carried amount
		// set and save carried_amount to distributor
		// add leadership_carried_amount commulated in various binary closings in previous 
		// (d.leadership_carried_amount already added in p.leadership_bonus in prev function)
		$q="
			UPDATE
				mlm_payout p
			JOIN mlm_distributor d on p.distributor_id=d.distributor_id
			SET 
				gross_payment = previous_carried_amount  + binary_income + introduction_amount + retail_profit + repurchase_bonus + generation_income + loyalty_bonus + leadership_bonus
			WHERE closing_id=$closing_id";
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
			WHERE closing_id=$closing_id";
		$this->query($q);

		// set net amount
		$q="
			UPDATE
				mlm_payout p
			JOIN mlm_distributor d on p.distributor_id=d.distributor_id
			JOIN customer c on c.contact_id = d.distributor_id
			SET 
				net_payment = gross_payment - ( tds + admin_charge )
			WHERE closing_id=$closing_id";
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
					/* ???????????????????????? */
					/*(p.month_self_bv < 250 OR d.monthly_green_intros = 0) OR*/
					net_payment < 500 /*OR
					d.is_document_verified = 0 OR
					d.is_document_verified is null*/
					/*
					OR (select count(distributor_id) from mlm_distributor li where li.introducer_id = d.distributor_id and li.path like concat(d.path,'A%')) < 1
					OR (select count(distributor_id) from mlm_distributor ri where ri.introducer_id = d.distributor_id and ri.path like concat(d.path,'B%')) < 1
					*/
				) AND

				closing_id=$closing_id
		";
		$this->query($q);

		$q="
			UPDATE 
				mlm_distributor d
			SET 
				monthly_green_intros = 0
				";
		$this->query($q);

		// add this carried amount in distributor for previous_carried_amount for next closing
		$q="
			UPDATE
				mlm_distributor d
			JOIN mlm_payout p on d.distributor_id = p.distributor_id
			SET
				d.carried_amount = p.carried_amount
			WHERE
				p.carried_amount is not null AND 
				p.carried_amount > 0 AND
				p.closing_id=$closing_id
		";
		$this->query($q);

		if($this->app->getConfig('remove_zero_income',true)){
			$q="
				DELETE p
					FROM
					mlm_payout p
				WHERE
					p.closing_id=$closing_id AND 
					p.net_payment = 0 and 
					p.carried_amount = 0
			";
			$this->query($q);
		}

		// non green not in payout but how to carry paris
		// non min purchase persons amount or min payout amount to carryied .. make tds admin etc zero 
		// put this in distributor carried amount field

	}

	function resetWeekData($on_date=null,$closing_id){
		if(!$on_date) $on_date = $this->app->today;
		// set fields zero in distributor 
		$q="
			DELETE FROM mlm_payout WHERE closing_id=$closing_id AND net_payment=0 AND carried_amount=0
		";
		$this->query($q);


	}

	function resetMonthData($on_date=null,$closing_id){
		if(!$on_date) $on_date = $this->app->today;
		// set fields zero in distributor 
		// like month_self_bv if greened_on is not null
		$this->resetWeekData($on_date,$closing_id);
	
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

	function setGenerationBonus($on_date=null){
		if(!$on_date) $on_date = $this->app->today;

		$q= "SELECT * from mlm_distributor WHERE month_self_bv > 0 ";
		$bv_dist=$this->query($q,true);		
		
		foreach ($bv_dist as $d) {
			$per = $d['temp']; // percentage
			if(!isset($this->generation_bonus[$d['distributor_id']])) $this->generation_bonus[$d['distributor_id']] = 0;
			$this->generation_bonus[$d['distributor_id']] = $this->generation_bonus[$d['distributor_id']] + ($d['month_self_bv'] * $per/100);
			$this->query("UPDATE mlm_distributor SET temp2=".$this->generation_bonus[$d['distributor_id']]." WHERE distributor_id=".$d['distributor_id']);
			$this->goUp($d,$per,$d['month_self_bv']);
		}
	}

	function goUp($d,$per,$bv){

		$d_path = $d['introducer_path'];
		$q="
				SELECT 
					* 
				FROM 
					mlm_distributor d
				WHERE
					POSITION(d.introducer_path in '$d_path') > 0
					AND d.introducer_path <> '$d_path'
					AND d.temp > $per
				ORDER BY length(d.introducer_path) desc
				LIMIT 1 
			";
		$up_dist=$this->query($q,true);
		$up_dist=$up_dist[0];

		if(isset($up_dist['id'])){
			if(!isset($this->generation_bonus[$up_dist['distributor_id']])) $this->generation_bonus[$up_dist['distributor_id']]=0;
			$this->generation_bonus[$up_dist['distributor_id']] = $this->generation_bonus[$up_dist['distributor_id']] + ($bv * ($up_dist['temp'] - $per) /100); // percentage
			$this->query("UPDATE mlm_distributor SET temp2=".$this->generation_bonus[$up_dist['distributor_id']]." WHERE distributor_id=".$up_dist['distributor_id']);
			$this->goUp($up_dist,$up_dist['temp'],$bv);
		}

	}

	function query($query, $gethash=false){
		if($gethash){
			return $this->app->db->dsql()->expr($query)->get();
		}else{
			return $this->app->db->dsql()->expr($query)->execute();
		}
	}

	function payoutsheet(){
		if($this['type']=='DailyClosing'){
			$this->app->js()->univ()->errorMessage('No Payout for Daily closing')->execute();
		}
		$this->app->redirect($this->app->url('xavoc_dm_payout',['closing_id'=>$this->id]));
	}
}
