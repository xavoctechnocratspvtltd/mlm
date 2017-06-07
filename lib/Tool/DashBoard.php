<?php

namespace xavoc\mlm;

/**
* 
*/
class Tool_DashBoard extends \xepan\cms\View_Tool{
	public $options = [
						'show-status'=>null,
	];
	
	function init(){
		parent::init();

		if($this->options['show-status']){
		}

		$this->add('xavoc\mlm\View_ProfileChecker');
		$this->add('View_Info')->set('Dashboard Tool');
	}
}