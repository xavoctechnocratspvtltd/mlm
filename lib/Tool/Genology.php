<?php

namespace xavoc\mlm;

/**
* 
*/
class Tool_Genology extends \xavoc\mlm\Tool_Distributor{
	
	public $options = [
						'genology-depth-of-tree'=> 4,
						'genology-show-info-on'=>"hover"
	];

	function init(){
		parent::init();
		if($this->owner instanceof \AbstractController) return;
		$d = $this->add('xavoc\mlm\Model_Distributor');
		$d->loadLoggedIn();
		if(!$d->loaded()) return;

		$this->add('xavoc\mlm\View_GenologyStandard',['options'=>$this->options]);
		// $this->add('xavoc\mlm\View_GenologyDynamic',['options'=>$this->options]);

	}
}
						
