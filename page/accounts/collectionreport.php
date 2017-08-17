<?php

namespace xavoc\mlm;

/**
* 
*/
class page_accounts_collectionreport extends \xepan\base\Page{

	public $title = "Account Collection Report";
	function init(){
		parent::init();

		$form = $this->add('Form');
		$form->setLayout('view/form/distributor-filter');
		// $form->addField('line','search');
		$form->addField('DatePicker','from_date');
		$form->addField('DatePicker','to_date');
		$form->addSubmit('Filter')->addClass('btn btn-primary');


		$collection_m = $this->add('xavoc\mlm\Model_Invoice');
		if($fd = $this->app->stickyGET('from_date')){
			$collection_m->addCondition('created_at','>',$fd);
		}

		if($td = $this->app->stickyGET('to_date')){
			$collection_m->addCondition('created_at','<',$this->app->nextDate($td));
		}

		$grid = $this->add('xepan\base\Grid');
		$grid->setModel($collection_m,['username','mobile_no','related_qsp_master_id','total_amount']);
		$grid->addPaginator(50);
		$grid->addSno('Sr.No');
		$grid->addTotals(['total_amount']);
		if($form->isSubmitted()){
			$grid->js()->reload(['from_date'=>$form['from_date']?:0,'to_date'=>$form['to_date']?:0])->execute();
		}

	}
}