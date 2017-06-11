<?php

namespace xavoc\mlm;


/**
* 
*/
class Model_Distributor_Actions extends \xavoc\mlm\Model_Distributor
{
	public $status = ['Active','Red','KitSelected','KitPaid','PaymentVerified','Green','InActive'];
	public $actions = [
				'Active'=>['view','edit','delete','InActive'],
				'InActive'=>['view','edit','delete','active'],
				'KitSelected'=>['view','edit','delete','payNow','verifyPayment','verifyDocument','InActive'],
				'KitPaid'=>['view','edit','delete','verifyPayment','verifyDocument','InActive'],
				'RedPay'=>['view','edit','delete','payNow','InActive'],
			];
	
	function init(){
		parent::init();

		$this->getElement('status')->defaultValue('Red');
	}

	function RedPay(){
		$this['status']='Red';
		$this->app->employee
            ->addActivity("Distributor : '".$this['name']."'  has been InActive", null/* Related Document ID*/, $this->id /*Related Contact ID*/,null,null,null)
            ->notifyWhoCan('Active,Red','InActive',$this);
		$this->saveAndUnload();
	}
	function kitSelected(){
		$this['status']='KitSelected';
		$this->app->employee
            ->addActivity("Distributor : '".$this['name']."'  has been InActive", null/* Related Document ID*/, $this->id /*Related Contact ID*/,null,null,null)
            ->notifyWhoCan('Active,KitSelected','InActive',$this);
		$this->saveAndUnload();
	}

	function InActive(){
		$this['status']='InActive';
		$this->app->employee
            ->addActivity("Distributor : '".$this['name']."'  has been InActive", null/* Related Document ID*/, $this->id /*Related Contact ID*/,null,null,null)
            ->notifyWhoCan('Active,Green','InActive',$this);
		$this->saveAndUnload();
	}

	function page_verifyPayment($page){
		$page->add('View')->set('verify Payment');

	}

	function page_verifyDocument($page){
		$page->add('View')->set('verify Document');
		
	}

	function page_payNow($page){
		$page->add('View')->set('Pay Now');
	}

}