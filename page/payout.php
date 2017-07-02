<?php


namespace xavoc\mlm;

class page_payout extends \xepan\base\Page {
	public $title= "Payout";

	function init(){
		parent::init();

		$closing_id = $this->app->stickyGET('closing_id');

		$m = $this->add('xavoc\mlm\Model_Payout');
		$m->addExpression('user')->set(function($m,$q){
			return $m->refSQL('distributor_id')->fieldQuery('user');
		});

		$m->addCondition('closing_id',$closing_id);

		$g = $this->add('Grid');
		$g->setModel($m);
		$g->addOrder()->move('user','after','distributor')->now();
		$g->removeColumn('closing');
		$g->addPaginator($ipp=100);
		$g->add("misc/Export");
	}
}