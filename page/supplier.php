<?php


namespace xavoc\mlm;

class page_supplier extends \xepan\base\Page {
	public $title= "Suppliers Management";

	function init(){
		parent::init();
		
		$crud = $this->add('xepan\hr\CRUD');
		$model= $this->add('xepan\commerce\Model_Supplier');
		
		

		$crud->setModel($model,['first_name','last_name'],['name']);
		$crud->grid->addQuickSearch(['name']);
		$crud->removeAttachment();
		$crud->grid->addOrder()->move('edit','last')->now();
		$crud->grid->addSno('Sr. No');
	}

}