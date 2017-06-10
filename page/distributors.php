<?php


namespace xavoc\mlm;

class page_distributors extends \xepan\base\Page {
	public $title= "Distributors";

	function init(){
		parent::init();


		$crud = $this->add('xepan\hr\CRUD');
		$crud->setModel('xavoc\mlm\Distributor');
		$crud->grid->addPaginator($ipp=50);
	}

}