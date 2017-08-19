<?php 
 namespace xavoc\mlm;
 class page_order_delivertopup extends \xepan\base\Page{

	public $title='Deliver Topup Order';

	function init(){
		parent::init();

		$topup_order = $this->add('xavoc\mlm\Model_Order_TopupDeliver');
		$topup_order->setOrder('id','desc');
		// $topup_order->addCondition('is_payment_verified',true);
		// $topup_order->addCondition('is_delivered',false);

		$crud = $this->add('xepan\hr\CRUD',['allow_add'=>false,'allow_edit'=>false,'allow_del'=>false]);
		$crud->setModel($topup_order,['id','is_delivered']);
		$crud->grid->addPaginator($ipp=25);
		$crud->removeAttachment();
	}
}