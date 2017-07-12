<?php


namespace xavoc\mlm;

class page_distributors extends \xepan\base\Page {
	public $title= "Distributors";

	function page_index(){
		// parent::init();
		$status_color = [
						'Red'=>'danger',
						'KitSelected'=>'default',
						'KitPaid'=>'primary',
						'Green'=>'success'
					];

		$dis_action_m = $this->add('xavoc\mlm\Model_Distributor_Actions');
		$dis_action_m->add('xavoc\mlm\Controller_SideBarStatusFilter');
		
		$crud = $this->add('xepan\hr\CRUD',['status_color'=>$status_color,'allow_del'=>false, 'allow_add'=>false]);
		$crud->setModel($dis_action_m,
						['country_id','state_id','address','city','pin_code'],
						['distributor_name','side','sponsor','introducer','joining_date','email','mobile_number']
					);
		$crud->grid->addPaginator($ipp=50);
		$crud->grid->removeColumn('attachment_icon');
		$crud->grid->addQuickSearch(['distributor_name']);
		
		if($crud->isEditing()){
			$form = $crud->form;
			$state_field = $form->getElement('state_id');
			$country_field = $form->getElement('country_id');
			$country_field->js('change',$form->js()->atk4_form('reloadField','state_id',[$this->app->url(null,['cut_object'=>$state_field->name]),'country_id'=>$country_field->js()->val()]));
			if($_GET['country_id']){
				$state_field->getModel()->addCondition('country_id',$_GET['country_id']);
			}
		}
		
	}

	function page_orderitem(){
		$document_id = $_GET['document_id'];
		$grid = $this->add('xepan\base\Grid');
		$sale_order = $this->add('xavoc\mlm\Model_SalesOrder');
		$sale_order->load($document_id);

		$grid->setModel($sale_order->items(),['item','is_package','price','quantity','total_amount']);

	}

}