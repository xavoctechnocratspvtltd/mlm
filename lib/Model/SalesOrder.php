<?php

namespace xavoc\mlm;

class Model_SalesOrder extends \xepan\commerce\Model_SalesOrder {
	public $table_alias =  'mlm_sale_order';
	public $status = ['Draft','Submitted','Redesign','Approved','InProgress','Canceled','Completed','Dispatched','OnlineUnpaid'];
	public $actions = [

	'Draft'=>['view','edit','delete','submit','verifyRepurchasePayment','manage_attachments'],
	'Submitted'=>['view','edit','delete','approve','redesign','print_document','verifyRepurchasePayment','manage_attachments'],
	'Approved'=>['view','edit','delete','inprogress','send','createInvoice','print_document','assign_for_shipping','manage_attachments'],
	'InProgress'=>['view','edit','delete','cancel','complete','send','manage_attachments'],
	'Canceled'=>['view','edit','delete','redraft','manage_attachments'],
	'Completed'=>['view','edit','delete','createInvoice','print_document','send','manage_attachments'],
	'OnlineUnpaid'=>['view','edit','delete','approve','createInvoice','print_document','send','verifyRepurchasePayment','manage_attachments'],
	'Redesign'=>['view','edit','delete','submit','manage_attachments']
	];
	/*
		['Draft'] => no used
		['Submitted'] => if online then invoice paid for this order else no invoice only order submitted
		['Approved'] => not used
		['InProgress'] => not used
		['completed'] => only dispatched
		['onlineUnpaid'] => order confirmed but could not be paid
	*/

	function init(){
		parent::init();

		$this->addExpression('is_topup_included')->set(function($m,$q){
			return $q->expr('IFNULL([0],0)',[$m->refSQL('xavoc\mlm\Model_QSPDetail')->sum('is_package')]);
		});
		
		$this->addExpression('items')->set($this->refSQL('Details')->count());
		$this->addExpression('invoice_detail')->set(function($m,$q){
			$in = $m->add('xepan\commerce\Model_SalesInvoice');
			$in->addCondition('related_qsp_master_id',$q->getField('id'));

			return $q->expr("CONCAT(IFNULL([0],' '),'-',IFNULL([1],' '))",[$in->fieldQuery('document_no'),$in->fieldQuery('status')]);
		})->caption('Invoice/Status');

		// is_delivered
		$this->addExpression('is_delivered')->set(function($m,$q){
			$sd = $m->add('xepan\commerce\Model_Store_Delivered');
			$sd->addCondition('related_document_id',$q->getField('id'));
			$sd->addCondition('status',['Delivered','Shipped']);
			return $sd->count();
			return $q->expr('IFNULL([0],0)',[$sd->count()]);
		})->type('boolean');

		$this->hasMany('xavoc\mlm\Model_QSPDetail','qsp_master_id');
	}

	function verifyRepurchasePayment(){
		if(!$this->loaded()) $this->throw('sale ordre model not loaded')->addMoreInfo('in mlm sale order');
		// mark order invoice and paid invoice
		// distribute repurchase value
		// mark order complete and dispatch the goods
		$sale_invoice = $this->invoice();
		$sale_invoice->paid();
		$this->complete();
	}

	function deleteOrder(){
		
		// delete invoice  and delete
		// topup history
		// delete repurchase history
		// update repurchase with negative bv or sv
		try{
			$this->app->db->beginTransaction();

			$th = $this->add('xavoc\mlm\Model_TopupHistory');
			$th->addCondition('distributor_id',$this['contact_id']);
			$th->addCondition('sale_order_id',$this->id);
			$th->tryLoadAny();

			$closing = $this->add('xavoc\mlm\Model_Closing');
			$closing->setOrder('id','desc');
			$closing->tryLoadAny();
			
			$last_closing_date = 0;
			if($closing->loaded())
				$last_closing_date = strtotime($closing['on_date']);
			
			if($last_closing_date > strtotime($th['created_at'])){
				throw new \Exception("you done a closing after topup, so cannot be delete");
			}
			
			if($this['is_topup_included']){
				$th->delete();
			}

			$temp_array = explode("-", $this['invoice_detail']);
			if($temp_array[0] > 0){
				$this->invoice()->delete();
			}


			if(!$this['is_topup_included']){
				$rh = $this->add('xavoc\mlm\Model_RepurchaseHistory');
				$rh->addCondition('distributor_id',$this['contact_id']);
				$rh->addCondition('sale_order_id',$this->id);
				$rh->tryLoadAny()->delete();
			}

			$total_bv = 0;
			$total_sv = 0;
			$total_ii = 0;
			foreach ($this->items() as $oi) {
		        $item = $this->add('xavoc\mlm\Model_Item')->load($oi['item_id']);
				$total_bv += $item['bv']*$oi['quantity'];
		        $total_sv += $item['sv']*$oi['quantity'];
		        $total_ii += $item['introducer_income'];
		    }

		    if($total_bv > 0 || $total_sv > 0){
		    	$dis = $this->add('xavoc\mlm\Model_Distributor');
		    	$dis->load($this['contact_id']);
		    	
		    	if($total_sv > 0){
		    		$dis->updateAnsestorsSV(-1 * $total_sv);

		    		if($this['is_topup_included'] && $total_ii > 0){
		    			if($introducer  = $dis->introducer()){
							$introducer->addSessionIntro($total_ii * -1);
							$introducer['monthly_green_intros'] = $introducer['monthly_green_intros']-1;
							$introducer->save();
						}
		    		}

		    	}
				
				if($total_bv > 0){
		    		$dis['month_self_bv'] = $dis['month_self_bv'] - $total_bv;
					$dis['total_self_bv'] = $dis['total_self_bv'] - $total_bv;
					
					$th = $this->add('xavoc\mlm\Model_TopupHistory');
					$th->addCondition('distributor_id',$this['contact_id']);
					$th->setOrder('id','desc');
					$th->tryLoadAny();
					if($th->loaded()){ 
						$dis['kit_item_id'] = $th['kit_item_id'];
					}else{
						$dis['kit_item_id'] = 0;
					}
					$dis->save();
					$dis->updateAnsestorsBV(-1 * $total_bv);
				}

		    }
			
			$this->delete();
			$this->app->db->commit();
		}catch(\Exception $e){
			$this->app->db->rollback();
			throw $e;
		}

		return true;
	}

	function page_assign_for_shipping($page){
		if(!$this->loaded()) throw new \Exception("model must loaded");

		// check order is already assigned or not
		$assign_order = $this->add('xavoc\mlm\Model_AssignOrder');
		$assign_order->addCondition('saleorder_id',$this['id']);

		if($assign_order->count()->getOne() > 1){
			throw new \Exception("assign to more then one franchises, that`s wrong ".$transaction->count()->getOne());
		}

		$assign_order->tryLoadAny();

		if($assign_order->loaded()){
			$page->add('View')->addClass('alert alert-info')->setHTML('order is already assign to franchise : <strong>'.$assign_order['franchises'].'</strong>');
		}

		$model = $page->add('xavoc\mlm\Model_Franchises');
		$model->addCondition('status','Active');

		$form = $page->add('Form');
		$f_field = $form->addField('xepan\base\DropDown','franchise')->validate('required');
		$f_field->setModel($model);
		$f_field->setEmptyText('Please Select Franchise');

		$form->addSubmit('Assign To Franchise');
		if($form->isSubmitted()){
			
			$assign_order['franchises_id'] = $form['franchise'];
			$assign_order['created_by_id'] = $this->app->auth->model->id;
			$assign_order->save();

			return $page->js(null,$page->js()->univ()->successMessage('Order Assigned'))->univ()->closeDialog();
		}

	}

	function isDelivered(){
		if(!$this->loaded()) throw new \Exception("model must loaded");
				
		$sd = $this->add('xepan\commerce\Model_Store_Delivered');
		$sd->addCondition('related_document_id',$this->id);
		$sd->addCondition('status',['Delivered','Shipped']);
		$sd->tryLoadAny();
		if($sd->loaded()) return $sd;

		return false;
	}

	function page_dispatch($page){
		if($this->isDelivered()){
			$page->add('View')->set('Order is Dispatched')->addClass('alert alert-success');
		}

		$view = $page->add('xavoc\mlm\View_FranchisesDispatch',['order_id'=>$this->id,'to_warehouse'=>'company']); // this function craete dispatch request and then dispatch by reverting from/to hencce to_ware is ok
		$ret = $view->getReturnJs();
		if($ret instanceof \jQuery_Chain) {
			$js_event = [$ret];
			$this->app->page_action_result = $this->app->js(true,$js_event);
		}
	}

	function dispatchComplete($from_warehouse_id, $delivery_details=[]){

		$deliver_model = $this->add('xepan\commerce\Model_Store_Delivered');
		$deliver_model['from_warehouse_id'] = $from_warehouse_id;
		$deliver_model['to_warehouse_id'] = $this['contact_id'];
		$deliver_model['related_document_id'] = $this->id;
		$deliver_model['delivery_via'] = $delivery_details['delivery_via'];
		$deliver_model['delivery_reference'] = $delivery_details['delivery_docket_no'];
		$deliver_model['narration'] = $delivery_details['narration'];
		$deliver_model['tracking_code'] = $delivery_details['tracking_code'];
		$deliver_model['status'] = 'Delivered';
		// $deliver_model['related_transaction_id'] = $this->related_transaction_id;
		$deliver_model->save();

		foreach ($this->items() as $dispatched_item) {
			$deliver_model->addItem(
								$dispatched_item->id,
								$dispatched_item['item_id'],
								$dispatched_item['quantity'],
								null,
								null,
								"Delivered"
							);
		}
		// $invoice = $this->invoice();
		// $invoice->paid();			
		return $deliver_model;
	}

} 