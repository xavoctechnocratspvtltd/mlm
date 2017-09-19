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
		$report_type = $_GET['report']?:'all';

		if($this->owner instanceof \AbstractController) return;

		$this->distributor = $distributor = $this->add('xavoc\mlm\Model_Distributor');
		$distributor->loadLoggedIn();
		if(!$distributor->loaded()){
			return "distributor not found";
		}
		
		$this->payout = $payout = $this->add('xavoc\mlm\Model_Payout');
		$payout->addExpression('date')->set($payout->dsql()->expr(' DATE_FORMAT(closing_date,"%d %b %y")'))->caption('Closing Date');
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
			case 'paid':
				$this->paidPayout();
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
		$previous_payout->addCondition('payout_type','WeeklyClosing');

		$sum_field = ['gross_payment','tds','admin_charge','net_payment'];
		foreach ($sum_field as $key => $field) {
			$previous_payout->addExpression('sum_'.$field)->set('sum('.$field.')')
				->caption(strtoupper(str_replace("_", " ", $field)))
				->display(['grid'=>'text']);
		}

		$previous_payout->setOrder('id','desc');
		$previous_payout->_dsql()->group('month_year');

		$this->add('View')->setStyle('height','30px');

		$v = $this->add('View')->addClass('main-box');
		$v->add('View')->setElement('h5')->set('Previous Months');
		$grid = $v->add('xepan\base\Grid');

		// $grid->addColumn('detail');
		$grid->setModel($previous_payout,['month_year','sum_gross_payment','sum_tds','sum_admin_charge','sum_net_payment','sum_carried_amount']);
		$grid->addPaginator($ipp=12);
		$grid->addColumn('expander','detail',['page'=>'xavoc_dm_mypayouts_detail']);
	}

	function allPayout(){
		$this->add('View')->setElement('h4')->set('Payout\'s');

		// current month payout
		$v = $this->add('View')->addClass('main-box');
		$v->add('View')->setElement('h5')
			->set('Current Month Payout - '.$this->current_month_year);

		$this->payout
			->addCondition('month_year',$this->current_month_year)
			;

		$grid = $v->add('xepan\base\Grid');
		$grid->setModel($this->payout,['date','binary_income','introduction_amount','repurchase_bonus','generation_income','loyalty_bonus','leadership_bonus','total_amt','previous_carried_amount','gross_payment','tds','admin_charge','net_payment','carried_amount','payout_type']);
		$grid->addPaginator($ipp=25);

		$grid->addFormatter('date','template')->setTemplate('{$date}<br/><small><small>({$payout_type})</small></small>','date');
		$grid->removeColumn('payout_type');
		$grid->addTotals(['binary_income','introduction_amount','repurchase_bonus','generation_income','loyalty_bonus','leadership_bonus','total_amt','gross_payment','tds','admin_charge','net_payment']);

		// previous payout
		$previous_payout = $this->add('xavoc\mlm\Model_Payout');
		$previous_payout->addExpression('date')->set($previous_payout->dsql()->expr(' DATE_FORMAT(closing_date,"%d %b %y")'));
		$previous_payout->addCondition('month_year','<>',$this->current_month_year);
		$previous_payout->addCondition('distributor_id',$this->distributor->id);

		$sum_field = ['binary_income'=>'BINARY AMT','introduction_amount'=>'INTRO AMT','repurchase_bonus'=>'REP BONUS','generation_income'=>'GEN INCOME','loyalty_bonus'=>'LOYALTY BONUS','leadership_bonus'=>'LEADER BONUS','total_amt'=>'TOTAL AMT','last_month_prev_amount'=>'PREV AMT','tds'=>'TDS','admin_charge'=>'ADMIN','net_payment'=>'NET AMT','last_carried_amount'=>'C/F'];
		foreach ($sum_field as $key => $field) {
			if($previous_payout->hasElement($key)){
				$previous_payout->addExpression('sum_'.$key)->set($this->app->db->dsql()->expr('sum([0])',[$previous_payout->getElement($key)]))
					->caption($field)
					->display(['grid'=>'text']);
			}
		}

		$previous_payout->addExpression('sum_gross_payment')->set(function($m,$q){
			return $q->expr('sum(IF([0]>0,[1],0))',[$m->getElement('net_payment'),$m->getElement('gross_payment')]);
		})->caption('GROSS AMT');

		$previous_payout->setOrder('id','desc');
		$previous_payout->_dsql()->group('month_year');

		$previous_payout->addExpression('last_month_prev_amount')->set(function($m,$q){
			$last_month_last_payout = $m->add('xavoc\mlm\Model_Payout',['table_alias'=>'prev_caried'])
										->addCondition('distributor_id',$q->getField('distributor_id'))
										->addCondition('closing_date','<',$q->getField('closing_date'))
										->setLimit(1)
										->setOrder('closing_date','desc')
										;
			return $last_month_last_payout->fieldQuery('carried_amount');
		})->caption('PREV. AMT');

		$previous_payout->addExpression('last_month_cf_amount')->set(function($m,$q){
			$last_month_last_payout = $m->add('xavoc\mlm\Model_Payout',['table_alias'=>'caried'])
										->addCondition('distributor_id',$q->getField('distributor_id'))
										->addCondition('month_year',$q->expr('DATE_FORMAT([0],"%b-%Y")',[$m->getElement('closing_date')]))
										->setLimit(1)
										->setOrder('closing_date','desc')
										;
			return $last_month_last_payout->fieldQuery('carried_amount');
		})->caption('C/F');

		$this->add('View')->setStyle('height','30px');

		$v = $this->add('View')->addClass('main-box');
		$v->add('View')->setElement('h5')->set('Previous Months');
		$grid = $v->add('xepan\base\Grid');

		// $grid->addColumn('detail');
		$grid->setModel($previous_payout,['month_year','sum_binary_income','sum_introduction_amount','sum_retail_profit','sum_repurchase_bonus','sum_generation_income','sum_loyalty_bonus','sum_leadership_bonus','sum_total_amt','last_month_prev_amount','sum_gross_payment','sum_tds','sum_admin_charge','sum_net_payment','last_month_cf_amount']);
		$grid->addPaginator($ipp=12);
		$grid->addColumn('expanderplus','detail',['page'=>'xavoc_dm_mypayouts_detail','descr'=>'Detail']);

		// $grid->js(true)->find('[type=checkbox]')->addClass('btn btn-primary');
		
	}

	function paidPayout(){

		$this->add('View')->setElement('h4')->set('Paid Payout\'s');

		// current month payout
		$v = $this->add('View')->addClass('main-box');
		// $v->add('View')->setElement('h5')
		// 	->set('Current Month Payout - '.$this->current_month_year);

		$this->payout
			// ->addCondition('month_year',$this->current_month_year)
			->addCondition('paid_on','<>',null)
			;

		$grid = $v->add('xepan\base\Grid');
		$grid->setModel($this->payout,['date','binary_income','introduction_amount','repurchase_bonus','generation_income','loyalty_bonus','leadership_bonus','total_amt','previous_carried_amount','gross_payment','tds','admin_charge','net_payment','payout_type','paid_amount','paid_on']);
		$grid->addPaginator($ipp=25);

		$grid->addFormatter('date','template')->setTemplate('{$date}<br/><small><small>({$payout_type})</small></small>','date');
		$grid->removeColumn('payout_type');
		$grid->addTotals(['binary_income','introduction_amount','repurchase_bonus','generation_income','loyalty_bonus','leadership_bonus','total_amt','gross_payment','tds','admin_charge','net_payment','paid_amount']);
	
	}

}