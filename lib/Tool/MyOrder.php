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

		switch ($this->app->stickyGET('action')){
			case 'orderdetail':
				$this->orderDetail();
				break;
			case 'courierdetail':
				$this->courierDetail();
				break;
			case 'invoicedetail':
				$this->invoiceDetail();
				break;
		}
	}

	function orderDetail(){
		$this->order = $my_order = $this->add('xavoc\mlm\Model_SalesOrder');
		$my_order->addCondition('contact_id',$this->distributor->id);
		$my_order->setOrder('id','desc');
		$my_order->getElement('document_no')->caption('Order No.');
		$my_order->getElement('created_at')->caption('Order Date');
		$my_order->getElement('items')->caption('Nos');

		$grid = $this->add('xepan\base\Grid');
		$grid->addSno('Sr. No.');
		$grid->setModel($my_order,['created_at','document_no','items','gross_amount','tax_amount','net_amount','details']);
		$self = $this;

		$this->vp = $this->add('VirtualPage')->set(function($p)use($self){
			$p->api->stickyGET('document_id');
			$o = $this->add('xavoc\mlm\Model_QSPDetail')->addCondition('qsp_master_id',$_GET['document_id']);
			$o->getElement('amount_excluding_tax')->caption('amount');
			$order = $p->add('xepan\base\Grid');
			$order->setModel($o,['name','item_sku','price','quantity','amount_excluding_tax','tax_amount','total_amount']);
		});

		// $grid->addColumn('details');
		// $grid->addMethod('format_details',function($g,$f){
		// 	$g->current_row_html[$f] = '<a class="btn btn-primary" href="#na" onclick="javascript:'.$g->js()->univ()->frameURL('Order Items '. $g->model['sales_order'], $this->api->url($this->vp->getURL(),array('sales_order_id'=>$g->model->id))).'">See Details</a>';
		// });
		// $grid->addFormatter('details','details');
		$grid->addColumn('expanderplus','details',['page'=>$this->vp->getURL(),'descr'=>'Details']);

		$grid->addQuickSearch(['document_no','created_at','status']);
		$grid->addPaginator(10);
	}


	function courierDetail(){
		$this->order = $my_order = $this->add('xavoc\mlm\Model_SalesOrder');

		$my_order->addExpression('courier_date')->set(function($m,$q){
			$sd = $m->add('xepan\commerce\Model_Store_Delivered');
			$sd->addCondition('related_document_id',$m->getElement('id'));
			$sd->addCondition('status',['Delivered','Shipped']);
			$sd->setOrder('id','desc');
			$sd->setLimit(1);
			return $q->expr('DATE([0])',[$sd->fieldQuery('created_at')]);
		});

		$my_order->addExpression('courier_name')->set(function($m,$q){
			$sd = $m->add('xepan\commerce\Model_Store_Delivered');
			$sd->addCondition('related_document_id',$m->getElement('id'));
			$sd->addCondition('status',['Delivered','Shipped']);
			$sd->setOrder('id','desc');
			$sd->setLimit(1);
			return $q->expr('DATE([0])',[$sd->fieldQuery('delivery_via')]);
		});

		$my_order->addCondition('contact_id',$this->distributor->id);
		$my_order->setOrder('id','desc');
		$my_order->getElement('document_no')->caption('Order No.');
		$my_order->getElement('created_at')->caption('Order Date');
		$my_order->getElement('items')->caption('Nos');
		$my_order->getElement('net_amount')->caption('Bill Amount');

		$grid = $this->add('xepan\base\Grid');
		$grid->addSno('Sr. No.');
		$grid->setModel($my_order,['created_at','document_no','invoice_no','invoice_date','net_amount','courier_date','courier_name','details']);
		$self = $this;

		$this->vp = $this->add('VirtualPage')->set(function($p)use($self){
			$p->api->stickyGET('document_id');
			$o = $this->add('xavoc\mlm\Model_QSPDetail')->addCondition('qsp_master_id',$_GET['document_id']);
			$o->getElement('amount_excluding_tax')->caption('amount');
			$order = $p->add('xepan\base\Grid');
			$order->setModel($o,['name','item_sku','price','quantity','amount_excluding_tax','tax_amount','total_amount']);
		});

		// $grid->addColumn('details');
		// $grid->addMethod('format_details',function($g,$f){
		// 	$g->current_row_html[$f] = '<a class="btn btn-primary" href="#na" onclick="javascript:'.$g->js()->univ()->frameURL('Order Items '. $g->model['sales_order'], $this->api->url($this->vp->getURL(),array('sales_order_id'=>$g->model->id))).'">See Details</a>';
		// });
		// $grid->addFormatter('details','details');

		$grid->addColumn('expanderplus','details',['page'=>$this->vp->getURL(),'descr'=>'Details']);

		$grid->addQuickSearch(['document_no','created_at','status']);
		$grid->addPaginator(10);
		
	}

	function invoiceDetail(){

		$model = $this->add('xavoc\mlm\Model_SalesInvoice');
		$model->addCondition('contact_id',$this->distributor->id);
		$model->setOrder('id','desc');
		$model->getElement('document_no')->caption('Invoice No.');
		$model->getElement('created_at')->caption('Invoice Date');
		$model->getElement('items')->caption('Nos');

		$grid = $this->add('xepan\base\Grid');
		$grid->addSno('Sr. No.');
		$grid->setModel($model,['created_at','document_no','items','gross_amount','tax_amount','net_amount','details']);
		$self = $this;

		$this->vp = $this->add('VirtualPage')->set(function($p)use($self){
			$p->api->stickyGET('document_id');
			$o = $this->add('xavoc\mlm\Model_QSPDetail')->addCondition('qsp_master_id',$_GET['document_id']);
			$o->getElement('amount_excluding_tax')->caption('amount');
			$order = $p->add('xepan\base\Grid');
			$order->setModel($o,['name','item_sku','price','quantity','amount_excluding_tax','tax_amount','total_amount']);
		});
		
		// $grid->addColumn('details');
		// $grid->addMethod('format_details',function($g,$f){
		// 	$g->current_row_html[$f] = '<a class="btn btn-primary" href="#na" onclick="javascript:'.$g->js()->univ()->frameURL('Invoice Items '. $g->model['document_no'], $this->api->url($this->vp->getURL(),array('sales_invoice_id'=>$g->model->id))).'">See Details</a>';
		// });
		// $grid->addFormatter('details','details');

		$grid->addColumn('expanderplus','details',['page'=>$this->vp->getURL(),'descr'=>'Details']);
		$grid->addQuickSearch(['document_no','created_at','status']);	
		$grid->addPaginator(10);
	}

}
						
