<?php

namespace xavoc\mlm;

/**
* 
*/
class Tool_WareHouse extends \xepan\cms\View_Tool{
	public $options = [
						'show-status'=>null,
	];

	function init(){
		parent::init();

		$this->add('View_Info')->set('WareHouse Tool');
	}
	
}