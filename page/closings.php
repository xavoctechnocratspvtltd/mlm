<?php


namespace xavoc\mlm;

class page_closings extends \xepan\base\Page {
	public $title= "Closings";

	function init(){
		parent::init();

		$crud = $this->add('xepan\hr\CRUD',['allow_add'=>false]);
		$crud->setModel('xavoc\mlm\Model_Closing');
	}

}