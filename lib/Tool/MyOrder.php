<?php

namespace xavoc\mlm;

/**
* 
*/
class Tool_MyOrder extends \xepan\cms\View_Tool{
	public $options = [''];

	function init(){
		parent::init();

		if($this->owner instanceof \AbstractController) return;

		$this->addClass('main-box bg bg-danger');
		$this->add('View_Info')->set('we are working on some awesome features for you.');
	
	}

}
						
