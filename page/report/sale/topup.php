<?php


namespace xavoc\mlm;

class page_report_sale_topup extends \xepan\base\Page{

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

		$topup_history_model = $this->add('xavoc\mlm\Model_TopupHistory');
		if($this->from_date)
			$topup_history_model->addCondition('created_at','>=',$this->from_date);
		if($this->to_date)
			$topup_history_model->addCondition('created_at','<',$this->app->nextDate($this->to_date));
		
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
		$v->add('View')->set('Total New Joining: '.$topup_history_model->count()->getOne())->addClass('alert alert-info');
		
		$grid = $v->add('xepan\base\Grid');
		$kit_model = $this->add('xepan\commerce\Model_Item');
		$kit_model->addCondition('is_package',true);

		$kit_model->addExpression('topups')->set(function($m,$q){
			$th = $m->add('xavoc\mlm\Model_TopupHistory')
				->addCondition('created_at','>=',$this->from_date)
				->addCondition('created_at','<',$this->app->nextDate($this->to_date))
				->addCondition('kit_item_id',$m->getElement('id'));
			return $q->expr('[0]',[$th->count()]);
		});

		$kit_model->addCondition('topups','>',0);
		$kit_model->setOrder('topups','desc');

		$grid->setModel($kit_model,['name','sku','topups']);
		$grid->addPaginator($ipp=50);
		$grid->addQuickSearch(['name']);

		$grid->add('VirtualPage')
			->addColumn('view_order')
 			->set(function($page){

				$item_id = $_GET[$page->short_name.'_id'];

				$sale_order = $page->add('xavoc\mlm\Model_SalesOrder');
				$sale_order->addCondition('is_topup_included',true);
				$sale_j = $sale_order->join('mlm_topup_history.sale_order_id');
				$sale_j->addField('kit_item_id');
				$sale_order->addCondition('kit_item_id',$item_id);
				$sale_order->addCondition('created_at','>=',$this->from_date);
				$sale_order->addCondition('created_at','<',$this->app->nextDate($this->to_date));

				// $page->add('View')->set($sale_order->count()->getOne());
				$grid_order = $page->add('xepan\base\Grid');
				$grid_order->setModel($sale_order,['contact','document_no','net_amount']);
				$grid_order->addPaginator($ipp=25);

			});

	}
}