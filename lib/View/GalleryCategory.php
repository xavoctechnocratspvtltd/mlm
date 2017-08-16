<?php

namespace xavoc\mlm;

class View_GalleryCategory extends \View{

	function init(){
		parent::init();


		$m = $this->add('xavoc\mlm\Model_GalleryCategory')
			->addCondition('status','active')
			;
		$grid = $this->add('CompleteLister');
		$grid->setModel($m);

	}
};