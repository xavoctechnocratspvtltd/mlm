<?php


namespace xavoc\mlm;

class page_kits extends \xepan\base\Page {
	public $title= "Kits Management";

	function init(){
		parent::init();
		
		$crud = $this->add('xepan\hr\CRUD');
		$model= $this->add('xavoc\mlm\Model_Kit');
		$crud->setModel($model,['name','sku','pv','bv','sv','dp','capping','introducer_income','item_count']);
		$crud->removeAttachment();
	}

}