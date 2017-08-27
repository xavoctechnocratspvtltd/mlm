<?php

namespace xavoc\mlm;


class Model_RepurchaseItem extends \xavoc\mlm\Model_Item{
	
	public $actions = [
		'Published'=>['view','edit','delete','detail','unpublish','addCategory'],
		'UnPublished'=>['view','edit','delete','publish']
	];

	function init(){
		parent::init();
		
		$this->addCondition('is_package',false);

		// $this->getElement('pv')->destroy();
		// $this->getElement('introducer_income')->destroy();
		// $this->getElement('capping')->destroy();
	}

	function detail(){
		$this->app->js()->univ()->newWindow($this->app->url('xepan_commerce_itemdetail',['action'=>'edit','document_id'=>$this->id]))->execute();
	}

	function page_addCategory($page){
		$cat_m = $this->add('xepan\commerce\Model_CategoryItemAssociation')->addCondition('item_id',$this->id);
		$crud = $page->add('xepan\base\CRUD');
		$crud->setModel($cat_m,['category_id'],['category']);
	}

}