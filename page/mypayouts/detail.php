<?php


namespace xavoc\mlm;

class page_mypayouts_detail extends \Page {

	function init(){
		parent::init();

		$payout_id = $_GET['mlm_payout_id'];
		
		$this->distributor = $distributor = $this->add('xavoc\mlm\Model_Distributor');
		$distributor->loadLoggedIn();
		if(!$distributor->loaded()){
			return "distributor not found";
		}

		$payout = $this->add('xavoc\mlm\Model_Payout');
		$payout->load($payout_id);
		$current_month_year = $payout['month_year'];

		$m_payout = $this->add('xavoc\mlm\Model_Payout');
		$m_payout->addExpression('date')->set($m_payout->dsql()->expr(' DATE_FORMAT(closing_date,"%d %b %y")'));
		$m_payout->addCondition('month_year',$current_month_year);
		$m_payout->addCondition('distributor_id',$this->distributor->id);
		// $m_payout->addCondition('payout_type','WeeklyClosing');
		$m_payout->setOrder('id','desc');

		$grid = $this->add('xepan\base\Grid');//->addClass('hide-header');
		$grid->setModel($m_payout,['date','binary_income','introduction_amount','repurchase_bonus','generation_income','loyalty_bonus','leadership_bonus','total_amt','previous_carried_amount','gross_payment','tds','admin_charge','net_payment','carried_amount','payout_type']);

		$grid->addFormatter('date','template')->setTemplate('{$date}<br/><small><small>({$payout_type})</small></small>','date');
		$grid->removeColumn('payout_type');
	}	
}