<?php


namespace xavoc\mlm;

class View_Report_Distributor_Downline extends \View{
	public $report_status;
	function init(){
		parent::init();

		$this->app->stickyGET('search_distributor');
		$this->app->stickyGET('status');
		$this->app->stickyGET('from_date');
		$this->app->stickyGET('to_date');
		$this->app->stickyGET('based_on');
		$this->app->stickyGET('leg');
		$this->app->stickyGET('rank');

		$this->add('View')->setElement('hr');
		$this->addClass('main-box');
	}

	function setModel($model){
		// add search related form
		$form = $this->add('Form');
		$form->add('xepan\base\Controller_FLC')
			->makePanelsCoppalsible(true)
			->layout([
				'search_distributor~Search Distributor/User/City/State'=>'Filter~c1~4',
				'leg'=>'c2~1',
				'rank'=>'c3~2',
				'from_date'=>'c4~2',
				'to_date'=>'c5~2',
				'FormButtons~'=>'c6~1'
				])
			;

		$search_field = $form->addField('search_distributor',null,'Search Distributor/User/City/State');
		$leg_field = $form->addField('DropDown','leg')->setValueList(['both'=>'Both','left'=>'Left','right'=>'Right']);
		$rank_field = $form->addField('DropDown','rank');
		$rank_field->setModel('xavoc/mlm/RePurchaseBonusSlab');
		$rank_field->setEmptyText('Select By Rank');

		$from_date_field = $form->addField('DatePicker','from_date');
		$to_date_field = $form->addField('DatePicker','to_date');
		$form->addSubmit('Go')->setStyle('margin','20px')->addClass('btn btn-primary');

		$downline = $this->add('xavoc\mlm\Model_Distributor');
		$downline->addCondition('path','like',$model['path'].'_%');
		$downline->addExpression('joining')->set(function($m,$q){
			return $q->expr('DATE([0])',[$m->getElement('created_at')]);
		});
		$downline->addExpression('green_on')->set(function($m,$q){
			return $q->expr('DATE([0])',[$m->getElement('greened_on')]);
		});

		
		if($this->report_status == "active"){
			$downline->addCondition('green_on','<>',null);
			$name = "Active Downline Report";
			$downline->setOrder('green_on','desc');
		}else{
			$downline->addCondition('green_on',null);
			$name = "Inactive Downline Report";
			$downline->setOrder('created_at','desc');
		}

		if($_GET['search_distributor']){
			$downline->addCondition([
									['user',$_GET['search_distributor']],
									['effective_name','like','%'.$_GET['search_distributor'].'%'],
									['id',$_GET['search_distributor']],
									['city',$_GET['search_distributor']],
									['state',$_GET['search_distributor']],
								]);

			$search_field->set($_GET['search_distributor']);
		}
		
		
		if($_GET['leg'] == 'left'){
			$downline->addCondition('side','A');
			$leg_field->set('left');
		}
		if($_GET['leg'] == 'right'){
			$downline->addCondition('side','B');
			$leg_field->set('right');
		}

		if($_GET['rank']){
			$downline->addCondition('current_rank_id',$_GET['rank']);
			$rank_field->set($_GET['rank']);
		}

		// if($_GET['status']){
		// 	$status_field->set($_GET['status']);
		// 	$downline->addCondition('status',$_GET['status']);
		// }

		if($_GET['from_date'] != null && $_GET['from_date'] != "null"){
			if($this->report_status == "active"){
				$downline->addCondition('greened_on','>=',$_GET['from_date']);
			}else
				$downline->addCondition('created_at','>=',$_GET['from_date']);
			
			$from_date_field->set($_GET['from_date']);
		}

		
		if($_GET['to_date'] != null && $_GET['to_date'] != "null"){

			if($this->report_status == "active"){
				$downline->addCondition('greened_on','<',$this->app->nextDate($_GET['to_date']));
			}else{
				$downline->addCondition('created_at','<',$this->app->nextDate($_GET['to_date']));
			}
			$to_date_field->set($_GET['to_date']);
		}

		$downline->getElement('green_on')->caption('Act. Date');
		$downline->getElement('user')->caption('User ID');
		$downline->getElement('name')->caption('User Name');
		$downline->getElement('side')->caption('Leg');
		// $downline->setOrder('id','desc');

		$fields = ['green_on','user','name','city','state','current_rank','path','side'];
		if($this->report_status == "inactive"){
			$fields = ['joining','user','name','city','state','path'];
		}

		$this->add('View')->setElement('h3')->set($name.' ('.$downline->count()->getOne().')');
		$this->add('View')->setElement('hr');
		$grid = $this->add('xepan\hr\Grid');
		$grid->setModel($downline,$fields);
		$grid->addSno('Sr. No.',true);
		
		// $grid->addMethod('format_leg',function($g,$f)use($model){

			// $g->current_row[$f]=($g->model['path'])[strlen($model['path'])] == 'A'?'Left':'Right';
		// });
		// $grid->addColumn('leg','leg');
		$grid->removeColumn('path');

		$grid->addPaginator($ipp=50);
		// reload self view with form values
		if($form->isSubmitted()){
			if($form['from_date'] && $form['to_date']){
				if(strtotime($form['from_date']) > strtotime($form['to_date']))
					$form->error('to_date','must be equal or greater then from date');
			}

			$this->js()->reload(['search_distributor'=>trim($form['search_distributor']),'from_date'=>$form['from_date'],'to_date'=>$form['to_date'],'leg'=>$form['leg'],'rank'=>$form['rank']])->execute();
		}
		return parent::setModel($model);
	}
}