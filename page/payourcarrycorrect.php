<?php


namespace xavoc\mlm;

class page_payourcarrycorrect extends \xepan\base\Page {
	public $title= "Test Page";

	function init(){
		parent::init();

		// correction for carried amount in closings
		$closings = $this->add('xavoc\mlm\Model_Closing');
		$closings->addCondition('type',['WeeklyClosing','MonthlyClosing']);
		$closings->setOrder(['on_date asc', 'id asc']);

		$q="UPDATE mlm_distributor d SET d.carried_amount=0";
		$this->query($q);

		$prev_closing_id=null;
		
		foreach ($closings as $c) {
			
			$closing_id = $c->id;

			$q="
				UPDATE
					mlm_payout p
				JOIN mlm_distributor d on p.distributor_id=d.distributor_id
				SET 
					p.previous_carried_amount = d.carried_amount
				WHERE closing_id=$closing_id";
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

			$prev_closing_id = $c->id;
		}
	}	

	function query($query, $gethash=false){
		$this->add('View')->set($query);
		if($gethash){
			return $this->app->db->dsql()->expr($query)->get();
		}else{
			return $this->app->db->dsql()->expr($query)->execute();
		}
	}
}