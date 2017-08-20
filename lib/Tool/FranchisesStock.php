<?php

namespace xavoc\mlm;

class Tool_FranchisesStock extends \xepan\cms\View_Tool{
	public $options = [];

	function init(){
		parent::init();
		
		$report = $this->app->stickyGET('report');

		if($this->owner instanceof \AbstractController) return;

		$this->addClass('main-box');

		$this->franchises = $franchises = $this->add('xavoc\mlm\Model_Franchises');
		$franchises->loadLoggedIn();

		switch ($report) {
			case 'itemstock':
				$this->add('View')->setElement('h4')->set('Stock Report');
				$this->add('xavoc\mlm\View_ItemStock',['warehouse_id'=>$this->franchises->id]);				
			break;
			case 'stocktransaction':
				$this->add('View')->setElement('h4')->set('Stock Transaction');
				$this->add('xavoc\mlm\View_StoreTransaction',['warehouse'=>$this->franchises->id]);
			break;
		}

	}
}