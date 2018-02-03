<?php


namespace xavoc\mlm;

class page_franchiseorder extends \xepan\base\Page {
	public $title= "Franchises Orders";

	function page_index(){
		$franch_model = $this->add('xavoc\mlm\Model_Franchises');
		$franch_ids_array=[];
		foreach ($franch_model as $key => $franch) {
			$franch_ids_array[]=$franch->id;
		}

		// var_dump($franch_ids_array);
		$sales_order = $this->add('xavoc\mlm\Model_SalesOrder');
		$sales_order->addCondition('created_by_id',$franch_ids_array);

		$crud = $this->add('xepan\hr\CRUD',['allow_add'=>false]);
		$crud->setModel($sales_order
						// ['first_name','country_id','state_id','','address','city','pin_code','status'],
						// ['first_name','country','state','','address','city','pin_code','status']
					);
		// $crud->grid->removeColumn('attachment_icon');
	}
}