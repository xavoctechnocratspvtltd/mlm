<?php

namespace xavoc\mlm;

class View_Repurchase extends \View{

	public $distributor=null;

	function init(){
		parent::init();

		if(!$this->distributor->loaded()){
		 	$this->add('View')
		 			->set('unknown distributor, distributor not found')
		 			->addClass('alert alert-danger');
		 	return;
		}

		$d_id = $this->distributor->id;

		$order = $this->add('xavoc\mlm\Model_SalesOrder');
		$order->addCondition('is_topup_included',false);
		$order->addCondition('contact_id',$d_id);
		$order->setOrder('id','desc');

		$grid = $this->add('xavoc\mlm\Grid_Order',['distributor'=>$this->distributor]);
		$grid->setModel($order,['document_no','net_amount','items','status','invoice_detail']);
		$grid->addColumn('expander','orderitem');
		$grid->addPaginator($ipp=3);
		$grid->addQuickSearch(['document_no']);
	}
}