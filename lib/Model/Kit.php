<?php

namespace xavoc\mlm;


class Model_Kit extends \xavoc\mlm\Model_Item{
	
	public $actions = [
		'Published'=>['view','edit','delete','unpublish','manage_package_items'],
		'UnPublished'=>['view','edit','delete','publish']
	];

	function init(){
		parent::init();
		$this->addCondition('is_package',true);

		$this->addExpression('item_count')->set(function($m,$q){
			return $m->refSQL('MyPackageItems')->count();
		});
	}

	function page_manage_package_items($page){
		$crud = $page->add('xepan/hr/CRUD');
		
		$model = $this->ref('MyPackageItems');

		if($crud->isEditing()){
			$model->getElement('item_id')->display('DropDown');
			$model->getElement('item_id')->getModel()->addCondition('is_package',false);
		}
		
		$crud->setModel($model,['item_id','qty'],['item','qty']);

	}
}