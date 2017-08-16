<?php

namespace xavoc\mlm;


class Model_GalleryCategory extends \xepan\base\Model_Table {
	public $table = "mlm_gallery_category";
	public $status = ['Active','InActive'];
	public $actions = [
					'Active'=>['view','edit','delete','image','deactivate'],
					'InActive'=>['view','edit','delete','activate']
					];

	function init(){
		parent::init();

		$this->addField('name');
		$this->addField('description')->display(['form'=>'xepan\base\RichText'])->type('text');
		$this->add('xepan\filestore\Field_File','image_id');

		$this->addField('status')->enum(['Active','InActive'])->defaultValue('Active');
		$this->addField('type');
		$this->addCondition('type','GalleryCategory');
		
		$this->hasMany('xavoc\mlm\Model_GalleryImages','category_id');

		$this->addExpression('images')->set($this->refSQL('xavoc\mlm\Model_GalleryImages')->count());

		$this->add('dynamic_model/Controller_AutoCreator');
	}

	function page_image($page){

		$img_model = $page->add('xavoc\mlm\Model_GalleryImages');
		$img_model->addCondition('category_id',$this->id);
		$crud = $page->add('CRUD');
		$crud->setModel($img_model);


	}
}