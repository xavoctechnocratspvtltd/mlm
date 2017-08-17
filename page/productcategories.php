<?php


namespace xavoc\mlm;

class page_productcategories extends \xepan\base\Page {
	public $title= "Product Categories";

	function page_index(){
		
		$crud = $this->add('xepan\hr\CRUD');
		$model= $this->add('xepan\commerce\Model_Category');
		$model->addExpression('products')->set(function($m,$q){
			return $m->refSQL('xepan\commerce\CategoryItemAssociation')->count();
		});

		$crud->setModel($model,['name','cat_image_id'],['name','cat_image','products']);
		$crud->removeAttachment();

		$crud->grid->addSno('Sr. No');


		$crud->grid->addOrder()->move('edit','last')->now();
		$crud->grid->addFormatter('products','template')->setTemplate('<a href="#" class="product-count">{$products}</a>','products');
		$crud->grid->addFormatter('cat_image','template')->setTemplate('<img src="{$cat_image}" />','cat_image');
		$crud->grid->js('click')->_selector('.product-count')->univ()->frameURL('Product list',[$this->app->url('./product_list'),'cat_id'=>$crud->js()->_selectorThis()->closest('tr')->data('id')]);
	}

	function page_product_list(){
		$grid = $this->add('xepan\base\Grid');
		$model = $this->add('xavoc\mlm\Model_Item');
		$cat_j = $model->join('category_item_association.item_id');
		$cat_j->addField('category_id');
		$model->addCondition('category_id',$_GET['cat_id']);
		$grid->setModel($model,['name']);
		$grid->addSno('Sr. No');
		$grid->add('View',null,'grid_buttons')->set($this->add('xepan/commerce/Model_Category')->load($_GET['cat_id'])->get('name'));
		$grid->removeSearchIcon();
	}

}