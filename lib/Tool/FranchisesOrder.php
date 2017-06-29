<?php

namespace xavoc\mlm;

class Tool_FranchisesOrder extends \xepan\cms\View_Tool{
	public $options = [];

	function init(){
		parent::init();
		
		if($this->owner instanceof \AbstractController) return;
		
		$this->addClass('main-box');
		$o_id = $this->app->stickyGET('order_id');
		
		$sale_order = $this->add('xavoc\mlm\Model_SalesOrder');
		if($o_id)
			$sale_order->tryLoadBy('document_no',$o_id);

		$v = $this->add('View');
		// $v->add('View_Error')->set("Order No : ".$o_id);

		$f = $v->add('Form');
		$f->addField('line','order_no');
		$f->addSubmit('Get Detail')->addClass('btn btn-primary');
		
		if($f->isSubmitted()){
			$js=[
					$v->js()->reload(['order_id'=>$f['order_no']])
			];
			$f->js(null,$js)->execute();	
		}
		
		if(!$sale_order->loaded()){
			return;
		}
		$order_view = $v->add('View',null,null,['view/franschises-order-item','order']);
		$order_view->setModel($sale_order);


		$contact = $sale_order->ref('contact_id');
		// throw new \Exception($contact['user'], 1);
		$inv = explode('-', $sale_order['invoice_detail']);
		$inv_no = $inv[0];
		$inv_status = $inv[1];

		$order_view->template->trySet('order_date',date('M d,Y',strtotime($sale_order['created_at'])));
		$order_view->template->trySet('dis_user_id',$contact['user']);
		$order_view->template->trySet('invoice_no',$inv_no);
		$order_view->template->trySet('invoice_status',$inv_status);

		if($inv_status === "Due"){
			$order_view->template->trySet('status_class',"text-danger");
		}else{
			$order_view->template->trySet('status_class',"text-success");
		}
		
		$order_view->add('Button',null,'btn_wrapper')->set('Dispatch')->addClass('btn btn-warning  pull-right');
		
		if($inv_status!=="Paid"){
			$pay_now_btn = $order_view->add('Button',null,'btn_wrapper')->set('Pay Now')->addClass('btn btn-success  pull-right');
			
			if($pay_now_btn->isClicked()){
				$sale_order->invoice()->paid();
				$this->js(null,$v->js()->reload())->reload()->execute();
			}	

		}else{
			$payment_detail_btn = $order_view->add('Button',null,'btn_wrapper')->set('Payment Detail')->addClass('btn btn-success  pull-right');
			if($payment_detail_btn->isClicked()){
				// $sale_order->invoice()->paid();
				$this->js(null,$v->js()->reload())->reload()->execute();
			}
		}




		$order_item = $this->add('xavoc\mlm\Model_QSPDetail');
		$order_item->addCondition('qsp_master_id',$sale_order->id);

		$cl = $v->add('CompleteLister',null,null,['view/franschises-order-item','order_item']);
		$cl->setModel($order_item);
	}
}