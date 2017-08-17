<?php


namespace xavoc\mlm;

class page_supplier extends \xepan\base\Page {
	public $title= "Suppliers Management";

	function init(){
		parent::init();
		
		$crud = $this->add('xepan\hr\CRUD');
		$model= $this->add('xepan\commerce\Model_Supplier');
		$model->getElement('organization')->caption('SUPPLIER FIRM NAME');

		$crud->setModel($model,
					['organization','first_name','last_name','address','city','state_id','country_id','pin_code','bank_name','bank_ifsc_code','account_no','account_type'],
					['organization','first_name','last_name','city','bank_name','bank_ifsc_code','account_no','account_type']
				);
		$crud->grid->addQuickSearch(['name']);
		$crud->removeAttachment();
		$crud->grid->addOrder()->move('edit','last')->now();
		$crud->grid->addSno('Sr. No');
	}

}