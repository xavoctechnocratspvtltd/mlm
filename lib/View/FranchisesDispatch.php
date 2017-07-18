<?php

namespace xavoc\mlm;

class View_FranchisesDispatch extends \View{
	public $order_id;
	public $return_js;

	function init(){
		parent::init();

		if(!$this->order_id) throw new \Exception("order id must must be defined");
		
		$this->franchises = $franchises = $this->add('xavoc\mlm\Model_Franchises');
		$this->franchises->loadLoggedIn();

		$order_id = $this->order_id;
		$order_model = $this->add('xavoc\mlm\Model_SalesOrder')->load($order_id);

		// warehouse try load store transaction entry with status received
		$transaction = $this->add('xepan\commerce\Model_Store_TransactionAbstract');
		$transaction->addCondition('related_document_id',$order_id);
		$transaction->addCondition('status','Received');
		$transaction->tryLoadAny();
				
		if($transaction->loaded()){
			$this->add('xepan\commerce\Model_Store_TransactionRow')->addCondition('store_transaction_id',$transaction->id)->deleteAll();
		}

		$transaction['type'] = "Store_DispatchRequest";
		$transaction['from_warehouse_id'] = $order_model['contact_id'];
		$transaction['to_warehouse_id'] = $this->franchises->id;
		$transaction['jobcard_id'] = null;
		$transaction['department_id'] = null;
		$transaction['narration'] = "system generated";
		$transaction['created_by_id'] = $this->app->auth->model->id;
		$transaction->save();

		$oi_id = 0;
		foreach ($order_model->orderItems() as $oi) {
			$oi_id = $oi->id;
			$transaction->addItem($oi['id'],$oi['item_id'],$oi['quantity'],null,null,'Received',null,null,false);
		}

		$x = $this->add('xepan\commerce\Model_Store_OrderItemDispatch')
			->load($oi_id);

		$ret = $x->page_dispatch($this);

		$this->return_js = $ret;
	}

	function getReturnJs(){
		return $this->return_js;
	}

};