<?php

namespace xavoc\mlm;

class Tool_FranchisesDispatch extends \xepan\cms\View_Tool{
	public $options = [];

	function init(){
		parent::init();
		
		if($this->owner instanceof \AbstractController) return;
		
		$this->addClass('main-box');
		$franchises = $franchises = $this->add('xavoc\mlm\Model_Franchises');
		$franchises->loadLoggedIn();

		$assign_order = $this->add('xavoc\mlm\Model_AssignOrder');
		$assign_order->addCondition('franchises_id',$franchises->id);
		$assign_order->addCondition('status','<>','Completed');

		$assign_orders_array = $assign_order->_dsql()->del('fields')->field('saleorder_id')->getAll();
		$assign_orders_array = iterator_to_array(new \RecursiveIteratorIterator(new \RecursiveArrayIterator($assign_orders_array)),false);

		$saleorder = $this->add('xavoc\mlm\Model_SalesOrder');
		$saleorder->getElement('document_no')->caption('Order No.');
		$saleorder->getElement('contact')->caption('customer');

		$saleorder->addCondition('id',$assign_orders_array);
		$saleorder->setOrder('id','desc');

		$grid = $this->add('xepan\base\Grid');
		$grid->setModel($saleorder,['document_no','contact','shipping_address','shipping_city','shipping_state','shipping_country','net_amount']);

		$grid->addHook('formatRow',function($g){
			$g->current_row_html['shipping_address'] = $g->model['shipping_address']."<br/>".$g->model['shipping_city']."<br/>".$g->model['shipping_state']."<br/>".$g->model['shipping_country'];
		});
		$grid->removeColumn('shipping_country');
		$grid->removeColumn('shipping_state');
		$grid->removeColumn('shipping_city');

		$grid->add('VirtualPage')
			->addColumn('Dispatch')
			->set(function($page){
				$id = $_GET[$page->short_name.'_id'];
				$page->add('Text')->set('ID='.$id);

				$x= $this->add('xepan\commerce\Model_Store_OrderItemDispatch')
					->tryLoadAny();

				$x->page_dispatch($page);

				// warehouse try load store transaction entry with status received

			});


	}
}