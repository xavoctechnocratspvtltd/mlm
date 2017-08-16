<?php

namespace xavoc\mlm;

/**
* 
*/
class Tool_ClosingAndPayouts extends \xepan\cms\View_Tool{
	public $options = [];
	public $current_month_year;
	public $payout;

	function init(){
		parent::init();
		$report_type = $_GET['report'];

		if($this->owner instanceof \AbstractController) return;

		$this->distributor = $distributor = $this->add('xavoc\mlm\Model_Distributor');
		$distributor->loadLoggedIn();
		if(!$distributor->loaded()){
			return "distributor not found";
		}
		
		$this->payout = $payout = $this->add('xavoc\mlm\Model_Payout');
		$payout->addExpression('date')->set($payout->dsql()->expr(' DATE_FORMAT(closing_date,"%d %b %y")'));
		// $payout->addExpression('month_year')->set($payout->dsql()->expr(' DATE_FORMAT(closing_date,"%b-%Y")'));
		// $payout->addExpression('payout_type')->set($payout->refSQL('closing_id')->fieldQuery('type'));
		$payout->addCondition('distributor_id',$this->distributor->id);

		$payout->setOrder('id','desc');

		$this->current_month_year = date('M-Y',strtotime($this->app->now));

		switch ($report_type) {
			case 'binary':
				$this->binaryPayout();
				break;
			case 'generation':
				$this->generationPayout();
				break;
			case 'all':
				$this->allPayout();
				break;
		}
	}

	function generationPayout(){
		$this->add('View')->setElement('h4')->set('Generation Payout');
		// current month payout
		$v = $this->add('View')->addClass('main-box');
		$v->add('View')->setElement('h5')
			->set('Current Month '.$this->current_month_year);

		$this->payout
			->addCondition('month_year',$this->current_month_year)
			->addCondition('payout_type','MonthlyClosing');
			;

		$grid = $v->add('xepan\base\Grid');
		$grid->setModel($this->payout,['date','previous_carried_amount','leadership_carried_amount','retail_profit','repurchase_bonus','generation_income','loyalty_bonus','leadership_bonus','gross_payment','tds','admin_charge','net_payment','carried_amount']);

		$previous_payout = $this->add('xavoc\mlm\Model_Payout');
		$previous_payout->addExpression('date')->set($previous_payout->dsql()->expr(' DATE_FORMAT(closing_date,"%d %b %y")'));
		$previous_payout->addCondition('month_year','<>',$this->current_month_year);
		$previous_payout->addCondition('distributor_id',$this->distributor->id);
		$previous_payout->addCondition('payout_type','MonthlyClosing');

		$sum_field = ['previous_carried_amount','leadership_carried_amount','binary_income','introduction_amount','gross_payment','tds','admin_charge','net_payment','carried_amount'];
		// foreach ($sum_field as $key => $field) {
		// 	$previous_payout->addExpression('sum_'.$field)->set('sum('.$field.')')->caption(strtoupper(str_replace("_", " ", $field)));
		// }

		$previous_payout->setOrder('id','desc');
		// $previous_payout->_dsql()->group('month_year');

		$this->add('View')->setStyle('height','30px');

		$v = $this->add('View')->addClass('main-box');
		$v->add('View')->setElement('h5')->set('Previous Months');
		$grid = $v->add('xepan\base\Grid');

		// $grid->addColumn('detail');
		$grid->setModel($previous_payout,['date','previous_carried_amount','leadership_carried_amount','retail_profit','repurchase_bonus','generation_income','loyalty_bonus','leadership_bonus','gross_payment','tds','admin_charge','net_payment','carried_amount']);
		$grid->addPaginator($ipp=12);
		// $grid->addColumn('expander','detail',['page'=>'xavoc_dm_mypayouts_detail']);
	}

	function binaryPayout(){
		$this->add('View')->setElement('h4')->set('Binary Payout');

		// current month payout
		$v = $this->add('View')->addClass('main-box');
		$v->add('View')->setElement('h5')
			->set('Current Month '.$this->current_month_year);

		$this->payout
			->addCondition('month_year',$this->current_month_year)
			->addCondition('payout_type','WeeklyClosing');
			;


		$grid = $v->add('xepan\base\Grid');
		$grid->setModel($this->payout,['date','previous_carried_amount','leadership_carried_amount','binary_income','introduction_amount','gross_payment','tds','admin_charge','net_payment','carried_amount']);

		$previous_payout = $this->add('xavoc\mlm\Model_Payout');
		$previous_payout->addExpression('date')->set($previous_payout->dsql()->expr(' DATE_FORMAT(closing_date,"%d %b %y")'));
		$previous_payout->addCondition('month_year','<>',$this->current_month_year);
		$previous_payout->addCondition('distributor_id',$this->distributor->id);

		$sum_field = ['previous_carried_amount','leadership_carried_amount','binary_income','introduction_amount','gross_payment','tds','admin_charge','net_payment','carried_amount'];
		foreach ($sum_field as $key => $field) {
			$previous_payout->addExpression('sum_'.$field)->set('sum('.$field.')')->caption(strtoupper(str_replace("_", " ", $field)));
		}

		$previous_payout->setOrder('id','desc');
		$previous_payout->_dsql()->group('month_year');

		$this->add('View')->setStyle('height','30px');

		$v = $this->add('View')->addClass('main-box');
		$v->add('View')->setElement('h5')->set('Previous Months');
		$grid = $v->add('xepan\base\Grid');

		// $grid->addColumn('detail');
		$grid->setModel($previous_payout,['month_year','sum_previous_carried_amount','sum_leadership_carried_amount','sum_binary_income','sum_introduction_amount','sum_gross_payment','sum_tds','sum_admin_charge','sum_net_payment','sum_carried_amount']);
		$grid->addPaginator($ipp=12);
		$grid->addColumn('expander','detail',['page'=>'xavoc_dm_mypayouts_detail']);
	}

	function allPayout(){
		$this->add('View')->setElement('h4')->set('Payout\'s');
		$grid = $this->add('xepan\base\Grid')->addClass('main-box');
		$grid->setModel($this->payout,['date','previous_carried_amount','binary_income','introduction_amount','retail_profit','repurchase_bonus','generation_income','loyalty_bonus','leadership_bonus','gross_payment','tds','admin_charge','net_payment','carried_amount']);
		$grid->addPaginator($ipp=25);
	}
}