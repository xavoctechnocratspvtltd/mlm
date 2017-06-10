<?php

namespace xavoc\mlm;


/**
* 
*/
class Model_Distributor_Actions extends \xavoc\mlm\Model_Distributor
{
	public $status = ['Active','Red','KitSelected','KitPaid','PaymentVerified','Green','InActive'];
	public $actions = [
				'Active'=>['view','edit','delete'],
				'InActive'=>['view','edit','delete','active'],
				'KitPaid'=>['view','edit','delete','verifyPayment'],
				'RedPay'=>['view','edit','delete','payNow'],
				'KitSelected'=>['view','edit','delete','verifyPayment'],
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
}