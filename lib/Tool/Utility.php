<?php

namespace xavoc\mlm;

/**
* 
*/
class Tool_Utility extends \xepan\cms\View_Tool{ 
	
	public $options = [];

	function init(){
		parent::init();

		$this->app->stickyGET('type');

		if($this->owner instanceof \AbstractController) return;

		$this->addClass('main-box');

		switch ($_GET['type']) {
			case 'gallery':
			$this->add('xavoc\mlm\View_GalleryCategory');
			break;
			case 'gallerylist':
			$this->add('xavoc\mlm\View_GalleryCategoryImage');
			break;
			case 'download':
			$this->add('xavoc\mlm\View_Download');
			break;
			case 'welcomeletter':
			$this->add('xavoc\mlm\View_WelcomeLetter');
			break;
		}
	}
}