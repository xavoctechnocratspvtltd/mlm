<?php 
 namespace xavoc\mlm;
 class page_order_verifytopup extends \xepan\base\Page{

	public $title='Verify Topup Order';

	function init(){
		parent::init();

		$topup_order = $this->add('xavoc\mlm\Model_Order_Topup');
		$topup_order->addCondition('is_payment_verified',false);
		
		$crud = $this->add('xepan\hr\CRUD',['allow_add'=>false,'allow_edit'=>false,'allow_del'=>false]);
		$crud->setModel($topup_order);

	}
}