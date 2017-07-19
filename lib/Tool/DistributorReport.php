<?php

namespace xavoc\mlm;

/**
* 
*/
class Tool_DistributorReport extends \xepan\cms\View_Tool{ 
	
	public $options = [
			'show-status'=>null,
	];

	function init(){
		parent::init();

		if($this->owner instanceof \AbstractController) return;
		
		$this->add('xavoc\mlm\View_DistributorReport');

	}
}