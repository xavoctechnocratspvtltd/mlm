<?php


namespace xavoc\mlm;

class page_payoutgenerationincomecorrect extends \xepan\base\Page {
	public $title= "Payout Generation Income Correct Page";

	function init(){
		parent::init();

		$closing = $this->add('xavoc\mlm\Model_Closing');
		$closing->setOrder('id','desc');
		$closing->tryLoadAny();

		$closing_id = $closing->id;

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
						FROM (select * from mlm_payout WHERE closing_id = $closing_id) pi
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

			$q="UPDATE mlm_payout p SET p.carried_amount=0 WHERE closing_id=$closing_id";
			$this->query($q);

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
						net_payment < 500  OR
						d.greened_on is null /*OR
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

			// Only if it is monthly
			// $q="
			// 	UPDATE 
			// 		mlm_distributor d
			// 	SET 
			// 		monthly_green_intros = 0
			// 		";
			// $this->query($q);

			
			// add this carried amount in distributor for previous_carried_amount for next closing
			$q="UPDATE mlm_distributor d SET d.carried_amount=0";
			$this->query($q);
			
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



	}	

	function query($query, $gethash=false){
		// $this->add('View')->set($query);
		if($gethash){
			return $this->app->db->dsql()->expr($query)->get();
		}else{
			return $this->app->db->dsql()->expr($query)->execute();
		}
	}
}