<?php


namespace xavoc\mlm;

class page_report_distributorlist extends \xavoc\mlm\page_report {
	public $title = "Distributor List";
	
	public $from_date;
	public $to_date;
	public $status;

	function init(){
		parent::init();

		$this->from_date = $from_date = $this->app->stickyGET('from_date')?:$this->app->today;
		$this->to_date = $to_date = $this->app->stickyGET('to_date')?:$this->app->today;
		$this->status = $this->app->stickyGET('status');

		$form = $this->add('Form');
		$v = $this->add('View');

		$col = $form->add('Columns')->addClass('row');
		$col1 = $col->addColumn('2')->addClass('col-md-3 col-lg-3 col-sm-12 col-xs-12');
		$col2 = $col->addColumn('2')->addClass('col-md-3 col-lg-3 col-sm-12 col-xs-12');
		$col3 = $col->addColumn('4')->addClass('col-md-3 col-lg-3 col-sm-12 col-xs-12');
				
		$submit_col = $col->addColumn('2')->addClass('col-md-3 col-lg-3 col-sm-12 col-xs-12');

		$from_date_field = $col1->addField('DatePicker','from_date');
		$to_date_field = $col2->addField('DatePicker','to_date');

		if($this->from_date)
			$from_date_field->set($this->from_date);
		if($this->to_date)
			$to_date_field->set($this->to_date);

		$col3->addField('DropDown','status')->setValueList(['All'=>'All','Red'=>'Red','KitSelected'=>'KitSelected','KitPaid'=>'KitPaid','Green'=>'Green','Blocked'=>'Blocked']);

		$submit_col->addSubmit('Submit')->addstyle('margin-top','20px')->addClass('btn btn-primary btn-block');
		if($form->isSubmitted()){
			$form->js(null,$v->js()->reload(['from_date'=>$form['from_date'],'to_date'=>$form['to_date'],'status'=>$form['status']]))->execute();
		}

		$v->add('View')->setElement('hr');
		$dis_m = $this->add('xavoc\mlm\Model_Distributor_Actions');
		$dis_m->addCondition('created_at','>=',$this->from_date);
		$dis_m->addCondition('created_at','<',$this->app->nextDate($this->to_date));

		if($this->status != "All"){
			$dis_m->addCondition('status',$this->status);
		}
		
		$v->add('View')->addClass('alert alert-info')->set('Total Distributors: '.$dis_m->count()->getOne());

		$grid = $v->add('xepan\hr\Grid');
		$grid->setModel($dis_m,['distributor_name','side','sponsor','introducer','status','joining_date','email','mobile_number']);

	}
}