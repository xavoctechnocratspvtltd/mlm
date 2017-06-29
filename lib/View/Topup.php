<?php

namespace xavoc\mlm;

class View_Topup extends \View{

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
		$order->addCondition('is_topup_included',true);
		$order->addCondition('contact_id',$d_id);
		$order->setOrder('id','desc');

		$grid = $this->add('xavoc\mlm\Grid_Order',['distributor'=>$this->distributor,'istopuporder'=>1,'allow_add'=>false,'allow_edit'=>false]);
		$grid->setModel($order,['document_no','net_amount','items','status','invoice_detail']);
		$grid->addColumn('expander','orderitem');
		$grid->addColumn('remove');
		$grid->addPaginator($ipp=5);
		$grid->addQuickSearch(['document_no']);
		
		$grid->removeColumn('attachment_icon');
		$grid->removeColumn('action');
	}
}