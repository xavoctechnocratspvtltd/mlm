<?php


namespace xavoc\mlm;

class page_kits extends \xepan\base\Page {
	public $title= "Kits Management";

	function init(){
		parent::init();
		
		$crud = $this->add('CRUD');
		$model= $this->add('xavoc\mlm\Model_Kit');
		$crud->setModel($model);
		$crud->addRef('xavoc\mlm\KitItem',['label'=>'Item']);		
	}

}