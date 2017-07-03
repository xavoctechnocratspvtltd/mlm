<?php

namespace xavoc\mlm;


class Model_RepurchaseItem extends \xavoc\mlm\Model_Item{
	
	public $actions = [
		'Published'=>['view','edit','delete','detail','unpublish'],
		'UnPublished'=>['view','edit','delete','publish']
	];

	function init(){
		parent::init();
		
		$this->addCondition('is_package',false);
		// $this->getElement('bv')->destroy();
		// $this->getElement('sv')->destroy();
		$this->getElement('pv')->destroy();
		$this->getElement('introducer_income')->destroy();
		$this->getElement('capping')->destroy();
		$this->getElement('dp')->destroy();
	}

	function detail(){
		$this->app->js()->univ()->newWindow($this->app->url('xepan_commerce_itemdetail',['action'=>'edit','document_id'=>$this->id]))->execute();
	}

}