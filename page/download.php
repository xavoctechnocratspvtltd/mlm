<?php


namespace xavoc\mlm;

class page_download extends \xepan\base\Page {
	public $title= "Gallery ";

	function init(){
		parent::init();

		$dl = $this->add('xavoc\mlm\Model_Download');

		$crud = $this->add('xepan\hr\CRUD');
		$crud->setModel($dl,['name','description','image_id','image'],['name','status','images']);
		
		$crud->grid->removeAttachment();
	}
}