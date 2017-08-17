<?php


namespace xavoc\mlm;

class page_kits extends \xepan\base\Page {
	public $title= "Kits Management";

	function init(){
		parent::init();
		
		$crud = $this->add('xepan\hr\CRUD');
		$model= $this->add('xavoc\mlm\Model_Kit');
		
		$model->addHook('beforeSave',function($m){			
			$m['sale_price']=$m['dp'];
		});

		$model->getElement('sale_price')->caption('MRP');

		$crud->setModel($model,['name','sku','hsn_sac','bv','sv','dp','capping','introducer_income','item_count'],['name','sku','hsn_sac','sale_price','bv','sv','dp','capping','introducer_income','item_count']);
		$crud->grid->addQuickSearch(['name','sku']);
		$crud->removeAttachment();
		$crud->grid->addOrder()->move('edit','last')->now();
		$crud->grid->addSno('Sr. No');
		$crud->grid->addPaginator(25);

		$crud->grid->removeColumn('hsn_sac');
		$crud->grid->addFormatter('sku','template')->setTemplate('{$sku}<br/>{$hsn_sac}','sku');
	}

}