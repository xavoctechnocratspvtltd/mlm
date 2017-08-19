<?php
 namespace xavoc\mlm;
 class page_order_verifyrepurchase extends \xepan\base\Page{

	public $title='Verify Repurchase Order';

	function init(){
		parent::init();

		$repurchase_order = $this->add('xavoc\mlm\Model_Order_Repurchase');
		$repurchase_order->addCondition('is_payment_verified',false);
		// $repurchase_order->debug();
		$repurchase_order->setOrder('id','desc');
		$crud = $this->add('xepan\hr\CRUD',['allow_add'=>false,'allow_edit'=>false,'allow_del'=>false]);
		$crud->setModel($repurchase_order,['document_no','created_at','user','contact','net_amount','action']);
		$crud->removeAttachment();
		$crud->grid->addPaginator(10);

		$crud->grid->addSno('Sr. No');

	}
}