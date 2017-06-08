<?php


namespace xavoc\mlm;

class page_distributoractions extends \xepan\base\Page {
	public $title= "Distributors Actions";

	function init(){
		parent::init();

		$dis_action_m = $this->add('xavoc\mlm\Model_Distributor_Actions');
		$crud = $this->add('xepan\hr\CRUD');
		$dis_action_m->add('xavoc\mlm\Controller_SideBarStatusFilter');
		$crud->setModel($dis_action_m);
	}

}