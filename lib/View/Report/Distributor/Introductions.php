<?php


namespace xavoc\mlm;

class View_Report_Distributor_Introductions extends \View{
	public $report_status;

	function init(){
		parent::init();

		$this->app->stickyGET('search_distributor');
		$this->app->stickyGET('status');
		$this->app->stickyGET('from_date');
		$this->app->stickyGET('to_date');
		$this->app->stickyGET('based_on');

		$this->add('View')->setElement('hr');
		$this->addClass('main-box');
	}

	function setModel($model){
		// add search related form
		$form = $this->add('Form');
		$col = $form->add('Columns')->addClass('row');
		$col1 = $col->addColumn('3')->addClass('col-md-7 col-sm-12 col-lg-7 col-xs-12');
		$col2 = $col->addColumn('2')->addClass('col-md-2 col-sm-12 col-lg-2 col-xs-12');
		$col3 = $col->addColumn('2')->addClass('col-md-2 col-sm-12 col-lg-2 col-xs-12');
		// $col4 = $col->addColumn('2')->addClass('col-md-2 col-sm-12 col-lg-2 col-xs-12');
		// $col5 = $col->addColumn('2')->addClass('col-md-2 col-sm-12 col-lg-2 col-xs-12');
		$submit_col = $col->addColumn('1')->addClass('col-lg-1 col-md-1 col-sm-12 col-lg-12');

		$search_field = $col1->addField('search_distributor',null,'Search User/Name');
		$from_date_field = $col2->addField('DatePicker','from_date');
		$to_date_field = $col3->addField('DatePicker','to_date');

		// $status_field = $col4->addField('xepan\base\DropDown','status')->setValueList(['Red'=>'Red','KitSelected'=>'KitSelected','Green'=>'Green','Blocked'=>'Blocked']);
		// $status_field->setEmptyText('All');
		// $based_on_field = $col5->addField('xepan\base\DropDown','based_on')->setValueList(['joining'=>'Joining Date','green'=>'Green On Date']);
		// if($_GET['based_on']){
		// 	$based_on_field->set($_GET['based_on']);
		// }

		$submit_col->addSubmit('Go')->setStyle('margin','20px')->addClass('btn btn-primary');

		$downline = $this->add('xavoc\mlm\Model_Distributor');
		$downline->addCondition('introducer_id','like',$model->id);
		$downline->addExpression('joining')->set(function($m,$q){
			return $q->expr('DATE([0])',[$m->getElement('created_at')]);
		});
		$downline->addExpression('green_on')->set(function($m,$q){
			return $q->expr('DATE([0])',[$m->getElement('greened_on')]);
		});


		if($this->report_status == "active"){
			$downline->addCondition('green_on','<>',null);
			$name = "Active Sponsored Report";
		}elseif($this->report_status == "inactive"){
			$downline->addCondition('green_on',null);
			$name = "Inactive Sponsored Report";
		}else{
			$name = "Direct Downline Report";
		}

		if($_GET['search_distributor']){
			$downline->addCondition([
									['user',$_GET['search_distributor']],
									['effective_name','like','%'.$_GET['search_distributor'].'%'],
									['id',$_GET['search_distributor']],
								]);
			$search_field->set($_GET['search_distributor']);
		}
		
		if($_GET['from_date'] != null && $_GET['from_date'] != "null"){
			if($this->report_status == "active"){
				$downline->addCondition('greened_on','>=',$_GET['from_date']);
			}elseif($this->report_status == "inactive" || $this->report_status == "downline_business")
				$downline->addCondition('created_at','>=',$_GET['from_date']);
			
			$from_date_field->set($_GET['from_date']);
		}

		
		if($_GET['to_date'] != null && $_GET['to_date'] != "null"){

			if($this->report_status == "active"){
				$downline->addCondition('greened_on','<',$this->app->nextDate($_GET['to_date']));
			}elseif($this->report_status == "inactive" || $this->report_status == "downline_business"){
				$downline->addCondition('created_at','<',$this->app->nextDate($_GET['to_date']));
			}
			$to_date_field->set($_GET['to_date']);
		}

		$fields = ['green_on','user','name','sponsor_id','introducer_id'];
		if($this->report_status == "inactive"){
			$fields = ['joining','user','name','sponsor_id','introducer_id'];
		}elseif($this->report_status == "downline_business"){
			$fields = ['joining','user','name','month_self_bv','total_month_bv'];
		}

		$downline->getElement('green_on')->caption('Act. Date');
		$downline->getElement('user')->caption('User ID');
		$downline->getElement('name')->caption('User Name');
		// $downline->getElement('green_on')->caption('Activation');

		$this->add('View')->setElement('h3')->set($name.' ('.$downline->count()->getOne().')');
		$this->add('View')->setElement('hr');
		$grid = $this->add('xepan\hr\Grid');
		$grid->setModel($downline,$fields);
		$grid->addSno('Sr. No.');
		$grid->addPaginator($ipp=100);
		// reload self view with form values
		if($form->isSubmitted()){
			if($form['from_date'] && $form['to_date']){
				if(strtotime($form['from_date']) > strtotime($form['to_date']))
					$form->error('to_date','must be equal or greater then from date');
			}

			$this->js()->reload(['search_distributor'=>trim($form['search_distributor']),'from_date'=>$form['from_date'],'to_date'=>$form['to_date']])->execute();
		}
		return parent::setModel($model);
	}
}