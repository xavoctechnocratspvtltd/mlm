<?php 
 namespace xavoc\mlm;
 class page_order_deliverrepurchase extends \xepan\base\Page{

	public $title='Deliver Repurchase Order';

	function init(){
		parent::init();

		$topup_order = $this->add('xavoc\mlm\Model_Order_Repurchase');
		$topup_order->addCondition('is_payment_verified',true);
		$topup_order->addCondition('is_delivered',false);

		$crud = $this->add('xepan\hr\CRUD',['allow_add'=>false,'allow_edit'=>false,'allow_del'=>false]);
		$crud->setModel($topup_order,['id','is_delivered']);
		$crud->grid->addPaginator($ipp=25);
		$crud->removeAttachment();
	}
}