<?php


namespace xavoc\mlm;

class View_Report_Distributor_Downline extends \View{
	function init(){
		parent::init();
	}

	function setModel($model){
		// add search related form
		$form = $this->add('Form');
		$form->addField('search_distributor');

		$downline = $this->add('xavoc\mlm\Model_Distributor');
		$downline->addCondition('path','like',$model['path'].'%');

		if($_GET['search_distributor']){
			$downline->addCondition([['user',$_GET['search_distributor']],['name','like','%'.$_GET['search_distributor'].'%'],['id',$_GET['search_distributor']]]);
		}
		
		$grid = $this->add('Grid');
		$grid->setModel($downline,['name','sponsor','introducer','current_rank','status']);

		$grid->addPaginator(100);
		// reload self view with form values
		if($form->isSubmitted()){
			$this->js()->reload(['search_distributor'=>$form['search_distributor']])->execute();
		}
		return parent::setModel($model);
	}
}