<?php


namespace xavoc\mlm;

class page_kits extends \xepan\base\Page {
	public $title= "Kits Management";

	function init(){
		parent::init();
		
		$crud = $this->add('CRUD');
		$model= $this->add('xavoc\mlm\Model_Kit');
		$crud->setModel($model,['qty_unit','name','sku','display_sequence','original_price','sale_price','pv','bv','sv','dp','capping','introducer_income','description']);
	}

}