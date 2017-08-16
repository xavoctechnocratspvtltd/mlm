<?php


namespace xavoc\mlm;

class page_productcategories extends \xepan\base\Page {
	public $title= "Product Categories";

	function init(){
		parent::init();

		$vp = $this->add('VirtualPage');
		$vp->set(function($page){
			$page->add('Text')->set('Hello');
		});
		
		$crud = $this->add('xepan\hr\CRUD');
		$model= $this->add('xepan\commerce\Model_Category');
		$model->addExpression('products')->set(function($m,$q){
			return $m->refSQL('xepan\commerce\CategoryItemAssociation')->count();
		});

		$crud->setModel($model,['name','products']);
		$crud->removeAttachment();

		$crud->grid->addTDParam('products', 'class', 'abcd');
		$crud->grid->addFormatter('products','link',['page'=>$vp->getURL()]);
	}

}