<?php


namespace xavoc\mlm;

class page_repurchase extends \xepan\base\Page {
	public $title= "Repurchase Item Management";

	function init(){
		parent::init();
		
		$crud = $this->add('xepan\hr\CRUD');
		$model= $this->add('xavoc\mlm\Model_RepurchaseItem');
		$crud->setModel($model,['qty_unit','name','sku','display_sequence','original_price','sale_price','pv','bv','sv','dp','capping','introducer_income','description','website_display','is_saleable']);
	}
}