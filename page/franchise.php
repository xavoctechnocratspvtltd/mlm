<?php


namespace xavoc\mlm;

class page_franchise extends \xepan\base\Page {
	public $title= "Franchises Management";

	function page_index(){
		$tabs = $this->add('Tabs');
		$tabs->addTabUrl('./list','List');
	}

	function page_list(){

		$franch_model = $this->add('xavoc\mlm\Model_Franchises');
		$crud = $this->add('xepan\hr\CRUD');
		$crud->setModel($franch_model,
						['first_name','country_id','state_id','','address','city','pin_code','website','status'],
						['first_name','country','state','','address','city','pin_code','website','status']
					);
		$crud->grid->removeColumn('attachment_icon');
	}
	
}