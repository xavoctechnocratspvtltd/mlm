<?php


namespace xavoc\mlm;

class page_franchiselist extends \xepan\base\Page {
	public $title= "Franchises List";

	function page_index(){
		// $tabs = $this->add('Tabs');
		// $tabs->addTabUrl('./list','List');
		$franch_model = $this->add('xavoc\mlm\Model_Franchises');
		$crud = $this->add('xepan\hr\CRUD');
		$crud->setModel($franch_model,
						['first_name','country_id','state_id','','address','city','pin_code','status'],
						['first_name','country','state','','address','city','pin_code','status']
					);
		$crud->grid->removeColumn('attachment_icon');
	}

	// function page_list(){

	// }
	
}