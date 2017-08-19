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
		$crud->setModel($model,['name','sku','hsn_sac','bv','sv','dp','sale_price','tax_percentage']);
		$crud->grid->addQuickSearch(['name','sku']);
		$crud->removeAttachment();
		$crud->grid->addOrder()->move('edit','last')->now();
		$crud->grid->addSno('Sr. No');

		$crud->grid->removeColumn('hsn_sac');
		$crud->grid->addFormatter('sku','template')->setTemplate('{$sku}<br/>{$hsn_sac}','sku');
	}
}