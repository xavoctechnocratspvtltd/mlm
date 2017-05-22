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

		$this->add('View_Info')->set('Genology Tool '. $this->options['genology-show-info-on']);
	}
}
						
