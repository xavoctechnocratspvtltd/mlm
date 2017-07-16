<?php

namespace xavoc\mlm;

class Tool_FranchisesDispatch extends \xepan\cms\View_Tool{
	public $options = [];
	public $franchises;

	function init(){
		parent::init();
		
		if($this->owner instanceof \AbstractController) return;
		
		$this->addClass('main-box');
		$this->franchises = $franchises = $this->add('xavoc\mlm\Model_Franchises');
		$franchises->loadLoggedIn();

		$assign_order = $this->add('xavoc\mlm\Model_AssignOrder');
		$assign_order->addCondition('franchises_id',$franchises->id);
		$assign_order->addCondition('status','<>','Completed');

		$assign_orders_array = $assign_order->_dsql()->del('fields')->field('saleorder_id')->getAll();
		$assign_orders_array = iterator_to_array(new \RecursiveIteratorIterator(new \RecursiveArrayIterator($assign_orders_array)),false);

		if(!count($assign_orders_array)){
			$this->add('View')->set('no record found')->addClass('alert alert-danger');
			return;
		}

		$saleorder = $this->add('xavoc\mlm\Model_SalesOrder');
		$saleorder->getElement('document_no')->caption('Order No.');
		$saleorder->getElement('contact')->caption('customer');

		$saleorder->addCondition('id',$assign_orders_array);
		$saleorder->setOrder('id','desc');

		$this->grid = $grid = $this->add('xepan\base\Grid');
		$grid->setModel($saleorder,['document_no','contact','shipping_address','shipping_city','shipping_state','shipping_country','net_amount']);

		$grid->addHook('formatRow',function($g){
			$g->current_row_html['shipping_address'] = $g->model['shipping_address']."<br/>".$g->model['shipping_city']."<br/>".$g->model['shipping_state']."<br/>".$g->model['shipping_country'];
		});
		$grid->removeColumn('shipping_country');
		$grid->removeColumn('shipping_state');
		$grid->removeColumn('shipping_city');
		$grid->addPaginator($ipp=25);
		$grid->addClass('franchises-dispatch');
		$grid->js('reload')->reload();



		$grid->add('VirtualPage')
			->addColumn('Dispatch')
			->set(function($page){
				$order_id = $_GET[$page->short_name.'_id'];
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

				$ret = $x->page_dispatch($page);
				if ($ret instanceof \jQuery_Chain) {
					// do order complete here why ?
					// because we not create the jobcard and on jobcard complete it' check order is complete or not
					// so i check here from store_deliverd model if has delivered or shipped model entry then marked the order complete
					$sd = $this->add('xepan\commerce\Model_Store_Delivered');
					$sd->addCondition('related_document_id',$order_model->id);
					$sd->addCondition('status',['Delivered','Shipped']);
					$sd->tryLoadAny();
					if($sd->loaded()){
						$order_model->complete();
					}

					$js_event = [$ret,$this->app->js()->_selector('.franchises-dispatch')->trigger('reload')];
					$this->app->js(true,$js_event)->execute();
				}
			});

	}
}