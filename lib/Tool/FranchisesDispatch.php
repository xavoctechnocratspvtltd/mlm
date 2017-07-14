<?php

namespace xavoc\mlm;

class Tool_FranchisesDispatch extends \xepan\cms\View_Tool{
	public $options = [];

	function init(){
		parent::init();
		
		if($this->owner instanceof \AbstractController) return;
		
		$this->addClass('main-box');
		
	}
}