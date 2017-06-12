<?php

namespace xavoc\mlm;

/**
* 
*/
class Tool_Genology extends \xepan\cms\View_Tool{
	
	public $options = [
						'genology-depth-of-tree'=> 5,
						'genology-show-info-on'=>"hover"
	];

	public $distributor = null ;
	public $start_distributor = null ;
	public $start_id = null ;
	public $level = 5 ;

	function init(){
		parent::init();

		$this->add('xavoc\mlm\View_GenologyStandard',['options'=>$this->options]);
		// $this->add('xavoc\mlm\View_GenologyDynamic',['options'=>$this->options]);

	}
}
						
