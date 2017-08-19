<?php 
 namespace xavoc\mlm;
 class page_dispatchorder extends \xepan\base\Page{

	public $title='Dispatched Order';

	function init(){
		parent::init();

		$dispached_order = $this->add('xavoc\mlm\Model_SalesOrder');
		// $dispached_order->addCondition('is_delivered',true);
		$dispached_order->setOrder('id','desc');

		$dispached_order->addExpression('user')->set($dispached_order->refSQL('contact_id')->fieldQuery('user'));
		$dispached_order->addExpression('mobile_no')->set($dispached_order->refSQL('contact_id')->fieldQuery('contacts_str'));
		$dispached_order->addExpression('city')->set($dispached_order->refSQL('contact_id')->fieldQuery('city'));
		
		$crud = $this->add('xepan\hr\CRUD',['allow_add'=>false,'allow_edit'=>false,'allow_del'=>false]);
		$crud->setModel($dispached_order,['user','name','city','document_no','invoice_detail','delivery_via','delivery_reference']);
		$crud->grid->addPaginator($ipp=25);
		$crud->removeAttachment();
		$crud->grid->addSno('Sr. No');
		$crud->grid->addColumn('Courier_date')->set('TODO');
		$crud->grid->addColumn('Courier_Name')->set('TODO');
		$crud->grid->addColumn('Pod_no')->set('TODO');
		$crud->grid->addColumn('Parcle_wt_kg')->set('TODO');
		$crud->grid->addColumn('courier_amount')->set('TODO');
	}
}