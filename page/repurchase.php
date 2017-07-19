<?php

namespace xavoc\mlm;

class page_repurchase extends \xepan\base\Page {
	public $title= "Repurchase Item Management";

	function init(){
		parent::init();
		
		$crud = $this->add('xepan\hr\CRUD');
		$model= $this->add('xavoc\mlm\Model_RepurchaseItem');
		// if($crud->isEditing()){
		// 	$form = $crud->form;
		// 	$form->setLayout('view/form/repurchaseitem');
		// }
		$crud->setModel($model,
				['name','sku','display_sequence','original_price','sale_price','qty_unit_id','pv','bv','sv','dp','capping','introducer_income','description','website_display','is_saleable'],
				['name','sku','display_sequence','original_price','sale_price','qty_unit','pv','bv','sv','dp','capping','introducer_income','website_display','is_saleable']
			);

		$crud->grid->addQuickSearch(['name','sku']);

	}
}