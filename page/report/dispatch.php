<?php


namespace xavoc\mlm;

class page_report_dispatch extends \xavoc\mlm\page_report {
	public $title = "Dispatch Report Id wise include franchises";
	public $from_date;
	public $to_date;
	public $franchise;
	public $distributor_id;

	function init(){
		parent::init();

		$this->from_date = $from_date = $this->app->stickyGET('from_date')?:$this->app->today;
		$this->to_date = $to_date = $this->app->stickyGET('to_date')?:$this->app->today;
		$this->franchise = $this->app->stickyGET('include');
		$this->distributor_id = $this->app->stickyGET('distributor_id');

		$form = $this->add('Form');
		$v = $this->add('View');

		$col = $form->add('Columns')->addClass('row');
		$col1 = $col->addColumn('2')->addClass('col-md-2 col-lg-2 col-sm-12 col-xs-12');
		$col2 = $col->addColumn('2')->addClass('col-md-2 col-lg-2 col-sm-12 col-xs-12');
		$col3 = $col->addColumn('3')->addClass('col-md-4 col-lg-4 col-sm-12 col-xs-12');
		$col4 = $col->addColumn('3')->addClass('col-md-2 col-lg-2 col-sm-12 col-xs-12');
				
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

		$distributor_field = $col3->add('View')->addField('autocomplete\Basic','distributor')->addClass('container');
		$distributor_field->setModel($distributor_model);

		$franchise_field = $col4->addField('DropDown','franchise');
		$franchise_field->setModel('xavoc\mlm\Model_Franchises');
		$franchise_field->setEmptyText('All');

		$submit_col->addSubmit('Submit')->addstyle('margin-top','20px')->addClass('btn btn-primary btn-block');
		if($form->isSubmitted()){
			$form->js(null,$v->js()->reload(['from_date'=>$form['from_date'],'to_date'=>$form['to_date'],'distributor_id'=>$form['distributor'],'franchise'=>$form['franchise']]))->execute();
		}

		$v->add('View')->setElement('hr');

		$store_delivered = $this->add('xepan\commerce\Model_Store_Delivered');
		$store_delivered->addCondition('created_at','>=',$this->from_date);
		$store_delivered->addCondition('created_at','<',$this->app->nextDate($this->to_date));
		
		if($this->distributor_id)
			$store_delivered->addCondition('related_contact_id',$this->distributor_id);

		if($this->franchise)
			$store_delivered->addCondition('from_warehouse_id',$this->franchise);

		$store_delivered->setOrder('id','desc');

		$store_delivered->getElement('related_document_no')->caption('Sale Order');

		$grid = $v->add('xepan\hr\Grid');
		$grid->setModel($store_delivered,['contact_name','organization_name','related_document_no','created_at','status','delivery_via','delivery_reference','shipping_address','shipping_charge','narration','from_warehouse']);

	}
}