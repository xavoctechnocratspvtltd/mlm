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
		$m_payout->addCondition('payout_type','WeeklyClosing');
		$m_payout->setOrder('id','desc');

		$grid = $this->add('xepan\base\Grid');//->addClass('hide-header');
		$grid->setModel($m_payout,['date','previous_carried_amount','leadership_carried_amount','binary_income','introduction_amount','gross_payment','tds','admin_charge','net_payment','carried_amount']);
	}	
}