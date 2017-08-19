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
		$topup_order->addExpression('user')->set($topup_order->refSQL('contact_id')->fieldQuery('user'));
		$topup_order->addExpression('mobile_no')->set($topup_order->refSQL('contact_id')->fieldQuery('contacts_str'));
		$topup_order->addExpression('city')->set($topup_order->refSQL('contact_id')->fieldQuery('city'));
		$crud = $this->add('xepan\hr\CRUD',['allow_add'=>false,'allow_edit'=>false,'allow_del'=>false]);
		$crud->setModel($topup_order,['user','name','mobile_no','city','document_no','net_amount']);
		$crud->grid->addPaginator($ipp=25);
		$crud->removeAttachment();
		$crud->grid->addSno('Sr. No');
	}
}