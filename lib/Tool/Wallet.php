<?php

namespace xavoc\mlm;

/**
* 
*/
class Tool_Wallet extends \xepan\cms\View_Tool{
	public $options = [''];

	function init(){
		parent::init();

		$this->add('View_Info')->set('Genology Tool');
	
	}

}
						
