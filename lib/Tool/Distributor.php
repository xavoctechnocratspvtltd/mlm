<?php

namespace xavoc\mlm;

/**
* 
*/
class Tool_Distributor extends \xepan\cms\View_Tool{ 
	public $options = [
			'show-status'=>null,
	];

	function init(){
		parent::init();

		if($this->owner instanceof \AbstractController) return;
		
		$this->distributor = $distributor = $this->add('xavoc\mlm\Model_Distributor');
		$distributor->loadLoggedIn();
		if(!$distributor->loaded()){
			$this->add('xavoc\mlm\View_DistributorNotFound');
			return;
		}

	}
}