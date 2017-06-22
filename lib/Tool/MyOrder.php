<?php

namespace xavoc\mlm;

/**
* 
*/
class Tool_MyOrder extends \xepan\cms\View_Tool{
	public $options = [''];

	function init(){
		parent::init();

		$this->addClass('main-box bg bg-danger');
		$this->add('View_Info')->set('we are working on some awesome features for you.');
	
	}

}
						
