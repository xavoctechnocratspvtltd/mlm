<?php


namespace xavoc\mlm;

class page_closings extends \xepan\base\Page {
	public $title= "Closings";

	function init(){
		parent::init();

		$crud = $this->add('xepan\hr\CRUD');
		$crud->setModel('xavoc\mlm\Model_Closing');
		if($crud->isEditing()){
			$crud->form->getElement('type')->setEmptyText('Please Select Closing type');
		}
	}

}