<?php


namespace xavoc\mlm;

class page_payout extends \xepan\base\Page {
	public $title= "Payout";

	function init(){
		parent::init();

		$closing_id = $this->app->stickyGET('closing_id');

		$closing = $this->add('xavoc\mlm\Model_Closing');
		$closing->load($closing_id);		
		$field_to_show = [];
		if($closing['type'] == "WeeklyClosing"){
			$field_to_show = ['distributor','user','closing_date','previous_carried_amount','leadership_carried_amount','binary_income','introduction_amount','gross_payment','tds','admin_charge','net_payment','carried_amount','account_number','bank_name','bank_ifsc_code','mobile_number','email','address'];
		}


		$m = $this->add('xavoc\mlm\Model_Payout');

		$m->addExpression('user')->set(function($m,$q){
			return $m->refSQL('distributor_id')->fieldQuery('user');
		});

		$m->addExpression('account_number')->set(function($m,$q){
			return $m->refSQL('distributor_id')->fieldQuery('d_account_number');
		});

		$m->addExpression('bank_name')->set(function($m,$q){
			return $m->refSQL('distributor_id')->fieldQuery('d_bank_name');
		});

		$m->addExpression('bank_ifsc_code')->set(function($m,$q){
			return $m->refSQL('distributor_id')->fieldQuery('d_bank_ifsc_code');
		});

		$m->addExpression('mobile_number')->set(function($m,$q){
			return $m->refSQL('distributor_id')->fieldQuery('mobile_number');
		});

		$m->addExpression('email')->set(function($m,$q){
			return $m->refSQL('distributor_id')->fieldQuery('email');
		});

		$m->addExpression('address')->set(function($m,$q){
			return $q->expr('CONCAT([0],", ",[1],", ",[2],", ",[3])',[
					$m->refSQL('distributor_id')->fieldQuery('address'),
					$m->refSQL('distributor_id')->fieldQuery('city'),
					$m->refSQL('distributor_id')->fieldQuery('state'),
					$m->refSQL('distributor_id')->fieldQuery('country'),
				]);
		});


		$m->addCondition('closing_id',$closing_id);

		$g = $this->add('Grid');

		if(count($field_to_show) > 0)
			$g->setModel($m,$field_to_show);
		else
			$g->setModel($m);

		$g->addOrder()->move('user','after','distributor')->now();
		$g->removeColumn('closing');
		$g->addPaginator($ipp=100);
		$g->add("misc/Export");
	}
}