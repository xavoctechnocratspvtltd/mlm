<?php


namespace xavoc\mlm;

class page_orderaction extends \Page {
	public $title = "Order";
	public $manage = "topup";

	function init(){
		parent::init();

		$actiontype = $this->app->stickyGET('actiontype');
		$orderid = $this->app->stickyGET('orderid');
		$distributor_id = $this->app->stickyGET('distributor_id');
		$istopuporder = $this->app->stickyGET('istopuporder')?:0;

		$action = $actiontype?:"payment";

		if($action == "payment" && $istopuporder){
			// topup payment verification
			$this->add('xavoc/mlm/View_VerifyTopupPayment',['orderid'=>$_GET['orderid'],'distributor_id'=>$_GET['distributor_id']]);
		
		}elseif($action == "payment" && !$istopuporder){
			// repurchase payment verification
			$this->add('xavoc/mlm/View_VerifyRepurchasePayment',['orderid'=>$_GET['orderid'],'distributor_id'=>$_GET['distributor_id']]);
		
		}elseif($action == "dispatch" && $istopuporder){

			$this->add('View')->set("topup dispatch view - ".$_GET['orderid']);
		
		}elseif($action == "dispatch" && !$istopuporder){
			$this->add('View')->set("repurchase dispatch view - ".$_GET['orderid']);
		}


	}
}