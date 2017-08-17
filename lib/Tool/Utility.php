<?php

namespace xavoc\mlm;

/**
* 
*/
class Tool_Utility extends \xepan\cms\View_Tool{ 
	
	public $options = [];

	function init(){
		parent::init();

		if($this->owner instanceof \AbstractController) return;

		$this->addClass('main-box');

		switch ($_GET['type']) {
			case 'gallery':
			$this->add('xavoc\mlm\View_GalleryCategory');
			break;	
			// case 'gallery':
			// break;
		}
	}
}