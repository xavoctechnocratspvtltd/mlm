<?php

namespace xavoc\mlm;

class Tool_FranchisesVerifyOrder extends \xepan\cms\View_Tool{
	public $options = [];

	public $order_id=0;
	public $saleOrder;
	public $v;
	function init(){
		parent::init();
		
		if($this->owner instanceof \AbstractController) return;

		$this->franchises = $franchises = $this->add('xavoc\mlm\Model_Franchises');
		$franchises->loadLoggedIn();
		
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

		$contact = $sale_order->ref('contact_id');
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
		
		
		if($inv_status != "Paid"){
			$pay_now_btn = $order_view->add('Button',null,'btn_wrapper')->set('Pay Now')->addClass('btn btn-success  pull-right');
			
			$pay_now_btn->add('VirtualPage')
				->bindEvent('Paid Payment of order '.$this->saleOrder['document_no'],'click')
				->set(function($page){
					$page->add('xavoc\mlm\View_FranchisesOrderPayment',['saleOrder'=>$this->saleOrder]);
				});

		}else{
			$payment_detail_btn = $order_view->add('Button',null,'btn_wrapper')->set('Payment Detail')->addClass('btn btn-success  pull-right');
			$payment_detail_btn->add('VirtualPage')
				->bindEvent('Payment Detail of Odrer '.$this->saleOrder['document_no'],'click')
				->set(function($page){

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
						
						$page->add('View')->setHtml("Payment Mode: <b>".$history['payment_mode']."</b>")->addClass('alert alert-success');
						foreach ($field_to_show as $key => $value) {
							if(in_array($value, ['office_receipt_image_id','dd_deposite_receipt_image_id','cheque_deposite_receipt_image_id'])){
								$page->add('View')->setElement('img')->setAttr('src',$history[str_replace("_id","" , $value)])->setStyle('width','100px;');
								// ->setAttr('src',$history[str_replace("id","", $value)]);
							}else		
								$page->add('View')->setHtml($value." : ".$history[$value])->addClass('alert alert-info');
						}
					}

				});
		}

		if(!$sale_order->isDelivered()){
			$form = $v->add('Form');
			$form->addField('text','narration')->validate('required');
			$form->addField('line','delivery_via')->validate('required');
			$form->addField('line','delivery_docket_no','Docket no/ Person name/ Other reference');
			$form->addField('line','tracking_code');
			$form->addSubmit('Dispatch');

			if($form->isSubmitted()){
				try{

					$this->app->db->beginTransaction();

					$sale_order->dispatchComplete($this->franchises->id,[
							'delivery_via'=>$form['delivery_via'],
							'delivery_docket_no'=>$form['delivery_docket_no'],
							'tracking_code'=>$form['tracking_code'],
							'narration' => $form['payment_narration']
						]);
					
					$this->app->db->commit();
					$v->js()->reload()->execute();
				}catch(Exception $e){
					$this->app->db->rollback();
					throw $e;
				}
			}
		}else{
			$v->add('H3')->set('Already Dispactehd');
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