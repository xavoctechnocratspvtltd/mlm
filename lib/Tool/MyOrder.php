<?php

namespace xavoc\mlm;

/**
* 
*/
class Tool_MyOrder extends \xavoc\mlm\Tool_Distributor{
	public $options = [''];
	public $vp;
	function init(){
		parent::init();

		if($this->owner instanceof \AbstractController) return;

		$this->distributor = $distributor = $this->add('xavoc\mlm\Model_Distributor');
		// $distributor->addExpression('attachment_count')->set(function($m,$q){
		// 	return $q->expr('IFNULL([0],0)',[$m->refSQL('xavoc\mlm\Attachment')->count()]);
		// });

		$distributor->loadLoggedIn();
		if(!$distributor->loaded()){
			return;
		}

		$this->addClass('main-box');
		// $this->add('View_Info')->set('we are working on some awesome features for you.');
		$my_order = $this->add('xavoc\mlm\Model_SalesOrder');
		$my_order->addCondition('contact_id',$distributor->id);
		$my_order->setOrder('id','desc');
		$my_order->getElement('document_no')->caption('Order No.');
		$my_order->getElement('created_at')->caption('Order Date');
		$my_order->getElement('items')->caption('Nos');

		$grid = $this->add('xepan\base\Grid');
		$grid->addSno('Sr. No.');
		$grid->setModel($my_order,['created_at','document_no','items','gross_amount','tax_amount','net_amount','details']);
		$self = $this;

		$this->vp = $this->add('VirtualPage')->set(function($p)use($self){
			$p->api->stickyGET('sales_order_id');
			$o = $this->add('xavoc\mlm\Model_QSPDetail')->addCondition('qsp_master_id',$_GET['sales_order_id']);
			$o->getElement('amount_excluding_tax')->caption('amount');
			$order = $p->add('xepan\base\Grid');
			$order->setModel($o,['name','item_sku','price','quantity','amount_excluding_tax','tax_amount','total_amount']);
		});
		$grid->addColumn('details');
		$grid->addMethod('format_details',function($g,$f){
			$g->current_row_html[$f] = '<a class="btn btn-primary" href="#na" onclick="javascript:'.$g->js()->univ()->frameURL('Order Items '. $g->model['sales_order'], $this->api->url($this->vp->getURL(),array('sales_order_id'=>$g->model->id))).'">See Details</a>';
		});
		$grid->addFormatter('details','details');

		$grid->addQuickSearch(['document_no','created_at','status']);	
		$grid->addPaginator(10);	
	}
}
						
