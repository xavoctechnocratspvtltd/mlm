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

				$view = $page->add('xavoc\mlm\View_FranchisesDispatch',['order_id'=>$order_id]);
				$ret = $view->getReturnJs();
				if ($ret instanceof \jQuery_Chain) {
					$js_event = [$ret,$this->app->redirect($this->app->url())];
					// $js_event = [$ret,$this->app->js()->_selector('.franchises-dispatch')->trigger('reload')];
					$this->app->js(true,$js_event)->execute();
				}
			});

	}
}