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

		$this->addClass('main-box');
		$this->add('xavoc\mlm\View_GenerationTree',['options'=>$this->options]);

	}
}
						
