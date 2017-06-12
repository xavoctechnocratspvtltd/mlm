<?php


namespace xavoc\mlm;

class page_payout extends \xepan\base\Page {
	public $title= "Payout";

	function init(){
		parent::init();

		$closing_id = $this->app->stickyGET('closing_id');

		$m = $this->add('xavoc\mlm\Model_Payout');
		$m->loadBy('closing_id',$closing_id);

		$g = $this->add('Grid');
		$g->setModel($m);
		$g->removeColumn('closing');
		$g->addPaginator($ipp=100);
		$g->add("misc/Export");
	}
}