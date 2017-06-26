<?php


namespace xavoc\mlm;

class page_orderaction extends \Page {
	public $title = "Order";
	public $manage = "topup";
	function init(){
		parent::init();

		$this->app->stickyGET('actiontype');
		$this->app->stickyGET('orderid');
		$this->app->stickyGET('distributor_id');

		$action = $_GET['actiontype']?:"payment";

		if($action == "payment"){
			$this->add('xavoc/mlm/View_VerifyTopupPayment',['orderid'=>$_GET['orderid'],'distributor_id'=>$_GET['distributor_id']]);
		}else{
			$this->add('View')->set("dispatch view - ".$_GET['orderid']);
		}

	}
}