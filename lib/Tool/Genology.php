<?php

namespace xavoc\mlm;

/**
* 
*/
class Tool_Genology extends \xepan\cms\View_Tool{
	
	public $options = [
						'genology-depth-of-tree'=> 4,
						'genology-show-info-on'=>"hover"
	];

	function init(){
		parent::init();
		if($this->owner instanceof \AbstractController) return;
		// $this->add('xavoc\mlm\View_GenologyStandard',['options'=>$this->options]);
		$this->add('xavoc\mlm\View_GenologyDynamic',['options'=>$this->options]);

	}
}
						
