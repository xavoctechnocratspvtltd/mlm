<?php

namespace xavoc\mlm;

/**
* 
*/
class Tool_GenerationTree extends \xavoc\mlm\Tool_Distributor{
	
	public $options = [
						'generation-depth-of-tree'=> 4,
						'generation-show-info-on'=>"hover"
	];

	function init(){
		parent::init();

		if($this->owner instanceof \AbstractController) return;

		$d = $this->add('xavoc\mlm\Model_Distributor');
		$d->loadLoggedIn();
		if(!$d->loaded()) return;

		$this->addClass('main-box');
		// $this->add('xavoc\mlm\View_GenerationTree',['options'=>$this->options]);
		$this->add('xavoc\mlm\View_GenerationJSTree',['options'=>$this->options]);

	}
}
						
