<?php

namespace xavoc\mlm;

class View_RepurchaseOrder extends \View{

	public $options= ['distributor_id'=>0];

	function init(){
		parent::init();

		$sale_order = $this->add('xavoc\mlm\Model_SalesOrder');

		if($this->options['distributor_id'])
			$sale_order->addCondition('contact_id',$this->options['distributor_id']);

		$sale_order->addCondition('status','<>','Completed');
		$sale_order->addExpression('items')->set($sale_order->refSQL('Details')->count());

		$grid = $this->add('xepan\base\Grid');
		$grid->setModel($sale_order,['document_no','status','items','net_amount']);
		$grid->addColumn('expander','orderitem');

		$grid->addColumn('verify');
		$grid->addMethod('format_verify',function($grid,$field){
			$grid->current_row_html[$field] = "<button class='ds-repurchase-verify-btn' data-orderid='".$grid->model->id."'>Verify</button>";
		});
		$grid->addFormatter('verify','verify');

		$grid_url = $this->api->url(null,['cut_object'=>$grid->name]);

		$grid->on('click','.ds-repurchase-verify-btn',function($js,$data)use($grid_url,$grid){
			$order_id = $data['orderid'];
			if($order_id){
				$sale_order = $this->add('xavoc\mlm\Model_SalesOrder')->load($order_id);
				$sale_order->verifyRepurchasePayment();
			}
			return $grid->js()->reload(null,null,$grid_url);
		});

		$grid->addPaginator($ipp=10);
	}
}