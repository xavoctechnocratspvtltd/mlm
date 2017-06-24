<?php

namespace xavoc\mlm;

/**
* 
*/
class Tool_ClosingAndPayouts extends \xepan\cms\View_Tool{
	public $options = [];
	
	function init(){
		parent::init();

		if($this->owner instanceof \AbstractController) return;

		$this->addClass('main-box');
		$this->distributor = $distributor = $this->add('xavoc\mlm\Model_Distributor');
		$distributor->loadLoggedIn();
		if(!$distributor->loaded()){
			return "distributor not found";
		}

		$this->add('View')->setElement('h4')->set('Payout\'s');
		$payout = $this->add('xavoc\mlm\Model_Payout')
				->addCondition('distributor_id',$distributor->id)
				->setOrder('id','desc')
				;
		$payout->addExpression('date')->set($payout->dsql()->expr(' DATE_FORMAT(closing_date,"%d %b %y")'));
		$grid = $this->add('xepan\base\Grid');
		$grid->setModel($payout,['date','previous_carried_amount','binary_income','introduction_amount','retail_profit','repurchase_bonus','generation_income','loyalty_bonus','leadership_bonus','gross_payment','tds','admin_charge','net_payment','carried_amount']);
		$grid->addPaginator($ipp=25);
	}
}