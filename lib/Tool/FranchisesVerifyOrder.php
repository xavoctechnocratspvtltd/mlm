<?php

namespace xavoc\mlm;

class Tool_FranchisesVerifyOrder extends \xepan\cms\View_Tool{
	public $options = [];

	public $order_id=0;
	public $saleOrder;
	public $v;

	function init(){
		parent::init();

		$this->franchises = $franchises = $this->add('xavoc\mlm\Model_Franchises');
		$franchises->loadLoggedIn();

		$action = $this->app->stickyGET('action');
		switch ($action) {
			case 'verify':
				$this->verifyOrder();
				break;
			case 'history':
				$this->orderHistory();
				break;
		}
	}

	function orderHistory(){

		$this->addClass('main-box');
		$oh = $this->add('xavoc\mlm\Model_SalesOrder');
		$oh->addCondition([
						['created_by_id',$this->franchises->id],
						['delivered_from_id',$this->franchises->id]
					]);
		$oh->setOrder('id','desc');
		$grid = $this->add('xepan\base\Grid');
		$grid->setModel($oh,['document_no','contact','created_at','status','invoice_detail','items','net_amount','is_delivered']);
		$grid->addSno('Sr. No.');
		$grid->addPaginator(25);

		$self = $this;
		$this->vp = $this->add('VirtualPage')->set(function($p)use($self){
			$p->api->stickyGET('sales_order_id');
			$o = $this->add('xavoc\mlm\Model_QSPDetail')->addCondition('qsp_master_id',$_GET['sales_order_id']);
			$o->getElement('amount_excluding_tax')->caption('amount');
			$order = $p->add('xepan\base\Grid');
			$order->setModel($o,['name','item_sku','price','quantity','amount_excluding_tax','tax_amount','total_amount']);
		});
		$grid->addMethod('format_items',function($g,$f){
			$g->current_row_html[$f] = '<a href="#na" onclick="javascript:'.$g->js()->univ()->frameURL('Order Items '. $g->model['sales_order'], $this->api->url($this->vp->getURL(),array('sales_order_id'=>$g->model->id))).'">View Items ( '. $g->current_row[$f] ." )</a>";
		});
		
		$grid->addFormatter('items','items');
	}

	function verifyOrder(){
		// parent::init();
		
		if($this->owner instanceof \AbstractController) return;

		$this->addClass('main-box franchises-order-verification');
		$this->js('reload')->reload();

		$this->order_id = $o_id = $this->app->stickyGET('order_id');
		
		$sale_order = $this->add('xavoc\mlm\Model_SalesOrder');
		$sale_order->title_field = 'document_no';
		if($o_id)
			$this->saleOrder = $sale_order->load($o_id);

		$this->v = $v = $this->add('View');

		$f = $v->add('Form');
		$field = $f->addField('autocomplete/Basic','order_no')->validate('required');
		$field->setModel($sale_order);

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

		$contact = $this->add('xavoc\mlm\Model_Distributor')->load($sale_order['contact_id']);
		// $contact = $sale_order->ref('contact_id');
		// throw new \Exception($contact['user'], 1);
		$inv = explode('-', $sale_order['invoice_detail']);
		$inv_no = $inv[0];
		$inv_status = $inv[1];

		$order_view->template->trySet('order_date',date('M d,Y',strtotime($sale_order['created_at'])));
		$order_view->template->trySet('dis_user_id',$contact['user']);
		$order_view->template->trySet('invoice_no',$inv_no);
		$order_view->template->trySet('invoice_status',$inv_status);

		if($inv_status == "Paid"){
			$order_view->template->trySet('status_class',"text-success");
		}else{
			$order_view->template->trySet('status_class',"text-danger");
		}

		$order_item = $this->add('xavoc\mlm\Model_QSPDetail');
		$order_item->addCondition('qsp_master_id',$sale_order->id);

		$cl = $v->add('CompleteLister',null,null,['view/franschises-order-item','order_item']);
		$cl->setModel($order_item);
		
		$v->add('View')->setElement('h4')->setHtml('Total Amount: '.$this->saleOrder['net_amount'])->addclass('text-right');

		$col = $v->add('Columns')->addClass('row');
		$left_col = $col->addColumn(6)->addClass('col-lg-6 col-md-6 col-sm-12 col-xs-12');
		$right_col = $col->addColumn(6)->addClass('col-lg-6 col-md-6 col-sm-12 col-xs-12');

		if($inv_status != "Paid"){
			$left_col->add('View')->addClass('alert alert-warning')->setHtml('<h2>Not Paid</h2>');
			return;
			// $left_col->add('xavoc\mlm\View_FranchisesOrderPayment',['saleOrder'=>$this->saleOrder]);
						
			// $pay_now_btn = $order_view->add('Button',null,'btn_wrapper')->set('Pay Now')->addClass('btn btn-success  pull-right');
			// $pay_now_btn->add('VirtualPage')
			// 	->bindEvent('Paid Payment of order '.$this->saleOrder['document_no'],'click')
				// ->set(function($page){
					// $page->add('xavoc\mlm\View_FranchisesOrderPayment',['saleOrder'=>$this->saleOrder]);
				// });

		}else{
			// $payment_detail_btn = $order_view->add('Button',null,'btn_wrapper')->set('Payment Detail')->addClass('btn btn-success  pull-right');
			// $payment_detail_btn->add('VirtualPage')
			// 	->bindEvent('Payment Detail of Odrer '.$this->saleOrder['document_no'],'click')
			// 	->set(function($page){
					$left_col->add('View')->setElement('h2')->set('Payment Detail')->addClass('alert alert-success');
					if($this->saleOrder['is_topup_included']){
						$history = $this->add('xavoc\mlm\Model_TopupHistory');
					}else{
						$history = $this->add('xavoc\mlm\Model_RepurchaseHistory');
					}

					$history->addCondition('distributor_id',$this->saleOrder['contact_id']);
					$history->addCondition('sale_order_id',$this->saleOrder->id);
					$history->tryLoadAny();

					$mandatory_field_set = [
						'online'=>['online_transaction_detail','online_transaction_reference','payment_narration'],
						'cheque'=>['bank_name','bank_ifsc_code','cheque_number','cheque_date','deposite_date','cheque_deposite_receipt_image_id','payment_narration'],
						'dd'=>['bank_name','bank_ifsc_code','dd_number','dd_date','deposite_date','dd_deposite_receipt_image_id','payment_narration'],
						'deposite_in_company'=>['office_receipt_image_id','payment_narration'],
						'deposite_in_franchies'=>['office_receipt_image_id','payment_narration']
					];

					if($history->loaded() AND isset($mandatory_field_set[$history['payment_mode']])){
						$field_to_show = $mandatory_field_set[$history['payment_mode']];						
						
						$left_col->add('View')->setHtml("Payment Mode: <b>".$history['payment_mode']."</b>")->addClass('alert alert-success');
						foreach ($field_to_show as $key => $value) {
							if(in_array($value, ['office_receipt_image_id','dd_deposite_receipt_image_id','cheque_deposite_receipt_image_id'])){
								$left_col->add('View')->setElement('img')->setAttr('src',$history[str_replace("_id","" , $value)])->setStyle('width','100px;');
								// ->setAttr('src',$history[str_replace("id","", $value)]);
							}else		
								$left_col->add('View')->setHtml($value." : ".$history[$value])->addClass('alert alert-info');
						}
					}

				// });
		}

		if(!$sd = $sale_order->isDelivered()){
			$right_col->add('View')->setElement('h2')->set('Dispatch Detail');
			$form = $right_col->add('Form');
			$form->addField('text','narration')->validate('required');
			$form->addField('line','delivery_via')->validate('required');
			$form->addField('line','delivery_docket_no','Docket no/ Person name/ Other reference');
			$form->addField('line','tracking_code');
			$form->addSubmit('Dispatch');

			if($form->isSubmitted()){
				try{

					$this->app->db->beginTransaction();

					$dispatch = $sale_order->dispatchComplete($this->franchises->id,[
							'delivery_via'=>$form['delivery_via'],
							'delivery_docket_no'=>$form['delivery_docket_no'],
							'tracking_code'=>$form['tracking_code'],
							'narration' => $form['narration']
						]);
					
					$this->app->db->commit();
					$data_array = array_merge($sale_order->data,$dispatch->data);
					$this->add('xavoc\mlm\Controller_Greet')->do($contact,'dispatch',$data_array);
					$v->js()->reload()->execute();
				}catch(Exception $e){
					$this->app->db->rollback();
					throw $e;
				}
			}
		}else{
			$right_col->add('H3')->set('Already Dispatched')->addClass('alert alert-success');
			$right_col->add('View')->setHtml('Narration: '.$sd['narration'])->addClass('alert alert-info');
			$right_col->add('View')->setHtml('Delivery Via: '.$sd['delivery_via'])->addClass('alert alert-info');
			$right_col->add('View')->setHtml('Docket no/ Person name/ Other reference: '.$sd['delivery_docket_no'])->addClass('alert alert-info');
			$right_col->add('View')->setHtml('Tracking Code: '.$sd['tracking_code'])->addClass('alert alert-info');
		}
		// $dispatch_btn = $order_view->add('Button',null,'btn_wrapper')->set('Dispatch')->addClass('btn btn-warning  pull-right');
		// $dispatch_btn->add('VirtualPage')
		// 		->bindEvent('Dispatch Order '.$this->saleOrder['document_no'],'click')
		// 		->set(function($page){

		// 			$view = $page->add('xavoc\mlm\View_FranchisesDispatch',['order_id'=>$this->saleOrder->id]);
		// 			$ret = $view->getReturnJs();
		// 			if ($ret instanceof \jQuery_Chain) {
		// 				$this->app->stickyForget('order_id');
		// 				$js_event = [$ret,$this->app->redirect($this->app->url())];
		// 				// $js_event = [$ret,$this->js()->_selector('.franchises-order-verification')->trigger('reload')];
		// 				$this->app->js(true,$js_event)->execute();
		// 			}
		// 		});

	}
}