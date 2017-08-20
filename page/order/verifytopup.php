<?php 
 namespace xavoc\mlm;
 class page_order_verifytopup extends \xepan\base\Page{

	public $title='Verify Topup Order';

	function init(){
		parent::init();

		$topup_order = $this->add('xavoc\mlm\Model_Order_Topup');
		$topup_order->addCondition('is_payment_verified',false);
		$topup_order->addExpression('user')->set($topup_order->refSQL('contact_id')->fieldQuery('user'));		
		$topup_order->setOrder('id','desc');
		
		$crud = $this->add('xepan\hr\CRUD',['allow_add'=>false,'allow_edit'=>false,'allow_del'=>false]);
		$crud->setModel($topup_order,['document_no','created_at','user','net_amount']);
		$crud->grid->addSno('Sr.No');
		$crud->removeAttachment();
	}
}