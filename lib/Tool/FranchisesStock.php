<?php

namespace xavoc\mlm;

class Tool_FranchisesStock extends \xepan\cms\View_Tool{
	public $options = [];

	function init(){
		parent::init();
		
		if($this->owner instanceof \AbstractController) return;

		$this->addClass('main-box');

		$this->franchises = $franchises = $this->add('xavoc\mlm\Model_Franchises');
		$franchises->loadLoggedIn();

		$this->add('View')->setElement('h4')->set('Stock Report');

		$this->add('xavoc\mlm\View_ItemStock',['warehouse_id'=>$this->franchises->id]);
	}
}