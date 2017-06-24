<?php

namespace xavoc\mlm;

class Tool_FranchisesDashboard extends \xepan\cms\View_Tool{
	public $options = [];

	function init(){
		parent::init();
		
		$this->addClass('main-box');
		$this->add('View')->set('Franchises Dashbaord Panel, feature are comming soon..');
	}
}