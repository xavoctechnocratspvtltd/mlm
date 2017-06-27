<?php

namespace xavoc\mlm;

class Tool_FranchisesSetting extends \xepan\cms\View_Tool{
	public $options = [];

	function init(){
		parent::init();
		
		if($this->owner instanceof \AbstractController) return;
		
		$this->addClass('main-box');
		$this->add('View')->set('Franchises Setting Panel, feature are comming soon..');
	}
}