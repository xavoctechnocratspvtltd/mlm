<?php


namespace xavoc\mlm;

class page_kits extends \xepan\base\Page {
	public $title= "Kits Management";

	function init(){
		parent::init();
		
		$crud = $this->add('CRUD');
		$model= $this->add('xavoc\mlm\Model_Item');
		$crud->setModel($model);
	}

}