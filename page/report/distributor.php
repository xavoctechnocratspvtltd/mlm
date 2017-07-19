<?php


namespace xavoc\mlm;

class page_report_distributor extends \xavoc\mlm\page_report {
	public $title = "Distributor Id wise Report";
	public $from_date;
	public $to_date;
	public $include;
	public $distributor_id;

	function init(){
		parent::init();

		$this->from_date = $from_date = $this->app->stickyGET('from_date')?:$this->app->today;
		$this->to_date = $to_date = $this->app->stickyGET('to_date')?:$this->app->today;
		$this->include = $this->app->stickyGET('include');
		$this->distributor_id = $this->app->stickyGET('distributor_id');

		$form = $this->add('Form');
		$v = $this->add('View');

		$col = $form->add('Columns')->addClass('row');
		$col1 = $col->addColumn('2')->addClass('col-md-2 col-lg-2 col-sm-12 col-xs-12');
		$col2 = $col->addColumn('2')->addClass('col-md-2 col-lg-2 col-sm-12 col-xs-12');
		$col3 = $col->addColumn('4')->addClass('col-md-4 col-lg-4 col-sm-12 col-xs-12');
		$col4 = $col->addColumn('2')->addClass('col-md-2 col-lg-2 col-sm-12 col-xs-12');
				
		$submit_col = $col->addColumn('2')->addClass('col-md-2 col-lg-2 col-sm-12 col-xs-12');

		$from_date_field = $col1->addField('DatePicker','from_date');
		$to_date_field = $col2->addField('DatePicker','to_date');

		if($this->from_date)
			$from_date_field->set($this->from_date);
		if($this->to_date)
			$to_date_field->set($this->to_date);

		$distributor_model = $this->add('xavoc\mlm\Model_Distributor');
		$distributor_model->addExpression('dis_id')->set(function($m,$q){
			return $q->expr('[0]',[$m->refSQL('user_id')->fieldQuery('username')]);
		});
		$distributor_model->title_field = 'dis_id';

		$distributor_field = $col3->add('View')->addField('autocomplete\Basic','distributor')->Validate('required')->addClass('container');
		$distributor_field->setModel($distributor_model);

		$col4->addField('DropDown','include')->setValueList(['all'=>'All','topup'=>'Topup Only','repurchase'=>'Repurchase Only']);

		$submit_col->addSubmit('Submit')->addstyle('margin-top','20px')->addClass('btn btn-primary btn-block');
		if($form->isSubmitted()){
			$form->js(null,$v->js()->reload(['from_date'=>$form['from_date'],'to_date'=>$form['to_date'],'distributor_id'=>$form['distributor'],'include'=>$form['include']]))->execute();
		}

		$v->add('View')->setElement('hr');
		$order_model = $this->add('xavoc\mlm\Model_SalesOrder');
		$order_model->addCondition('created_at','>=',$this->from_date);
		$order_model->addCondition('created_at','<',$this->app->nextDate($this->to_date));
		
		if($this->include == "topup"){
			$order_model->addCondition('is_topup_included',true);
		}
		if($this->include == "repurchase"){
			$order_model->addCondition('is_topup_included',false);	
		}

		$order_model->addCondition('contact_id',$this->distributor_id);
		$order_model->setOrder('id','desc');

		$order_model->getElement('document_no')->caption('Sale Order');
		$grid = $v->add('xepan\hr\Grid');
		$grid->setModel($order_model,['document_no','created_at','is_topup_included','net_amount']);

	}
}