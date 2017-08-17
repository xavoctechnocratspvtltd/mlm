<?php


namespace xavoc\mlm;

class page_gallery extends \xepan\base\Page {
	public $title= "Gallery ";

	function init(){
		parent::init();

		$cat = $this->add('xavoc\mlm\Model_GalleryCategory');

		$crud = $this->add('xepan\hr\CRUD');
		$crud->setModel($cat,['name','description','image_id','image'],['name','status','images']);
		$crud->grid->removeColumn('status');
		$crud->grid->removeColumn('attachment_icon');
	}
}