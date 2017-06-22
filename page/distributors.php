<?php


namespace xavoc\mlm;

class page_distributors extends \xepan\base\Page {
	public $title= "Distributors";

	function init(){
		parent::init();
		$status_color = [
						'Red'=>'danger',
						'KitSelected'=>'default',
						'KitPaid'=>'primary',
						'Green'=>'success'
					];

		$dis_action_m = $this->add('xavoc\mlm\Model_Distributor_Actions');
		
		$crud = $this->add('xepan\hr\CRUD',['status_color'=>$status_color,'allow_edit'=>false,'allow_del'=>false, 'allow_add'=>false]);
		$dis_action_m->add('xavoc\mlm\Controller_SideBarStatusFilter');
		$crud->setModel($dis_action_m,
						[''],
						['distributor_name','side','sponsor','introducer','joining_date','email','mobile_number']
					);
		$crud->grid->addPaginator($ipp=50);
		$crud->grid->removeColumn('attachment_icon');
		$crud->grid->addQuickSearch(['distributor_name']);
	}

}