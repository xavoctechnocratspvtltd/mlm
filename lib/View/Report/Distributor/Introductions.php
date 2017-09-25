<?php


namespace xavoc\mlm;

class View_Report_Distributor_Introductions extends \View{
	public $report_status;

	function init(){
		parent::init();

		$this->app->stickyGET('search_distributor');
		$this->app->stickyGET('search_placement');
		$this->app->stickyGET('search_intro');
		$this->app->stickyGET('from_date');
		$this->app->stickyGET('to_date');
		$this->app->stickyGET('based_on');
		$this->app->stickyGET('status');

		$this->add('View')->setElement('hr');
		$this->addClass('main-box');
	}

	function setModel($model){
		// add search related form
		$form = $this->add('Form');
		$form->add('xepan\base\Controller_FLC')
			->makePanelsCoppalsible(true)
			->layout([
				'search_distributor~Search User Id/Name'=>'Filter~c1~3',
				'search_placement~Placement Id/Name'=>'c2~3',
				'search_intro~Intro Id/Name'=>'c3~3',
				'from_date'=>'c4~2',
				'to_date'=>'c4~2',
				'FormButtons~'=>'c6~1'
				])
			;

		$search_field = $form->addField('search_distributor',null,'Search User/Name');
		$placement_field = $form->addField('search_placement',null,'Search Placement ID/Name');
		$intro_field = $form->addField('search_intro',null,'Search Intro ID/Name');

		$from_date_field = $form->addField('DatePicker','from_date');
		$to_date_field = $form->addField('DatePicker','to_date');
		$form->addSubmit('Go')->setStyle('margin','20px')->addClass('btn btn-primary');


		$downline = $this->add('xavoc\mlm\Model_Distributor');
		$downline->addCondition('introducer_id','like',$model->id);
		$downline->addExpression('joining')->set(function($m,$q){
			return $q->expr('DATE([0])',[$m->getElement('created_at')]);
		});
		$downline->addExpression('green_on')->set(function($m,$q){
			return $q->expr('DATE([0])',[$m->getElement('greened_on')]);
		});
		$downline->addExpression('intro_name')->set(function($m,$q){
			return $q->expr('[0]',[$m->refSql('introducer_id')->fieldQuery('name')]);
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

		if($placement = $_GET['search_placement']){
			$placement_field->set($placement);
			$downline->addCondition([
						['sponsor_id',$placement],
						['sponsor',$placement]]
					);
		}

		if($intro = $_GET['search_intro']){
			$intro_field->set($intro);
			$downline->addCondition([
						['introducer_id',$intro],
						['intro_name',$intro],
						['introducer',$intro]
					]);
		}

		$fields = ['green_on','user','name','sponsor_id','sponsor','introducer_id','intro_name'];
		if($this->report_status == "inactive"){
			$fields = ['joining','user','name','sponsor_id','introducer_id'];
		}elseif($this->report_status == "downline_business"){
			$fields = ['joining','user','name','month_self_bv','total_month_bv'];
		}


		$downline->getElement('sponsor_id')->caption('Placement ID');
		$downline->getElement('sponsor')->caption('Placement Name');
		$downline->getElement('introducer_id')->caption('Intro ID');
		

		$downline->getElement('green_on')->caption('Act. Date');
		$downline->getElement('user')->caption('User ID');
		$downline->getElement('name')->caption('User Name');
		// $downline->getElement('green_on')->caption('Activation');

		$this->add('View')->setElement('h3')->set($name.' ('.$downline->count()->getOne().')');
		$this->add('View')->setElement('hr');
		$grid = $this->add('xepan\hr\Grid');
		$grid->setModel($downline,$fields);
		$grid->addSno('Sr. No.',true);
		$grid->addPaginator($ipp=100);
		// reload self view with form values
		if($form->isSubmitted()){
			if($form['from_date'] && $form['to_date']){
				if(strtotime($form['from_date']) > strtotime($form['to_date']))
					$form->error('to_date','must be equal or greater then from date');
			}

			$this->js()->reload([
								'search_distributor'=>trim($form['search_distributor']),
								'search_placement'=>trim($form['search_placement']),
								'search_intro'=>trim($form['search_intro']),
								'from_date'=>$form['from_date'],
								'to_date'=>$form['to_date'],
							])->execute();
		}
		return parent::setModel($model);
	}
}