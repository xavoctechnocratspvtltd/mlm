<?php

namespace xavoc\mlm;

/**
* 
*/
class Tool_GenerationTree extends \xepan\cms\View_Tool{
	
	public $options = [
						'generation-depth-of-tree'=> 5,
						'generation-show-info-on'=>"hover"
	];

	public $distributor = null ;
	public $start_distributor = null ;
	public $start_id = null ;
	public $level = 5 ;

	function init(){
		parent::init();

		if($this->owner instanceof \AbstractController) return;

		$this->addClass('main-box');
		$this->add('xavoc\mlm\View_GenerationTree',['options'=>$this->options]);

	}
}
						
