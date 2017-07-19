<?php


namespace xavoc\mlm;

class page_report_sale_repurchase extends \xepan\base\Page{

	public $from_date;
	public $to_date;
	function init(){
		parent::init();


		$this->from_date = $from_date = $this->app->stickyGET('from_date')?:$this->app->today;
		$this->to_date = $to_date = $this->app->stickyGET('to_date')?:$this->app->today;

		$form = $this->add('Form');
		$v = $this->add('View');

		$col = $form->add('Columns')->addClass('row');
		$col1 = $col->addColumn('4')->addClass('col-md-4 col-lg-4 col-sm-12 col-xs-12');
		$col2 = $col->addColumn('4')->addClass('col-md-4 col-lg-4 col-sm-12 col-xs-12');
		$col3 = $col->addColumn('4')->addClass('col-md-4 col-lg-4 col-sm-12 col-xs-12');

		$re_history_model = $this->add('xavoc\mlm\Model_RepurchaseHistory');
		if($this->from_date)
			$re_history_model->addCondition('created_at','>=',$this->from_date);
		if($this->to_date)
			$re_history_model->addCondition('created_at','<',$this->app->nextDate($this->to_date));
						
		$from_date_field = $col1->addField('DatePicker','from_date');
		$to_date_field = $col2->addField('DatePicker','to_date');

		if($this->from_date)
			$from_date_field->set($this->from_date);
		if($this->to_date)
			$to_date_field->set($this->to_date);

		$col3->addSubmit('Submit')->addstyle('margin-top','20px')->addClass('btn btn-primary btn-block');

		if($form->isSubmitted()){
			$form->js(null,$v->js()->reload(['from_date'=>$form['from_date'],'to_date'=>$form['to_date']]))->execute();
		}

		
		$v->add('View')->setElement('hr');
		$v->add('View')->set('Total Repurchase Order: '.$re_history_model->count()->getOne())->addClass('alert alert-info');
		
		$grid = $v->add('xepan\base\Grid');
		$repurchase_model = $this->add('xepan\commerce\Model_Item');
		$repurchase_model->addCondition('is_package',false);

		$repurchase_model->addExpression('orders')->set(function($m,$q){
			$qsp_detail = $m->add('xavoc\mlm\Model_QSPDetail');
			$qsp_detail->addCondition('item_id',$m->getElement('id'));
			$qsp_detail->addCondition('qsp_created_date','>=',$this->from_date);
			$qsp_detail->addCondition('qsp_created_date','<',$this->app->nextDate($this->to_date));
			return $q->expr('[0]',[$qsp_detail->count()]);
		});

		$repurchase_model->addExpression('orders_qty')->set(function($m,$q){
			$qsp_detail = $m->add('xavoc\mlm\Model_QSPDetail');
			$qsp_detail->addCondition('item_id',$m->getElement('id'));
			$qsp_detail->addCondition('qsp_created_date','>=',$this->from_date);
			$qsp_detail->addCondition('qsp_created_date','<',$this->app->nextDate($this->to_date));
			return $q->expr('[0]',[$qsp_detail->sum('quantity')]);
		});

		$repurchase_model->addCondition('orders','>',0);
		$repurchase_model->setOrder('orders','desc');

		$grid->setModel($repurchase_model,['name','sku','orders','orders_qty']);
		$grid->addPaginator($ipp=50);
		$grid->addQuickSearch(['name']);

		// $grid->add('VirtualPage')
		// 	->addColumn('view_order')
 	// 		->set(function($page){

		// 		$item_id = $_GET[$page->short_name.'_id'];

		// 		$sale_order = $page->add('xavoc\mlm\Model_SalesOrder');
		// 		$sale_order->addCondition('is_topup_included',false);
		// 		$sale_j = $sale_order->join('mlm_repurchase_order_history.sale_order_id');
		// 		$sale_order->addCondition('created_at','>=',$this->from_date);
		// 		$sale_order->addCondition('created_at','<',$this->app->nextDate($this->to_date));

		// 		$grid_order = $page->add('xepan\base\Grid');
		// 		$grid_order->setModel($sale_order,['contact','document_no','net_amount']);
		// 		$grid_order->addPaginator($ipp=25);

		// 	});
	}
}