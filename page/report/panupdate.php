<?php


namespace xavoc\mlm;

class page_report_panupdate extends \xavoc\mlm\page_report {
	
	function init(){
		parent::init();

		$model = $this->add('xavoc\mlm\Model_Distributor');
			
		$model->getElement('pan_no')->sortable(true);

		$model->addExpression('pan_card_id')->set(function($m,$q){
			return $m->refSQL('xavoc\mlm\Attachment')->setLimit(1)->fieldQuery('pan_card');
		})->sortable(true);

		$model->addCondition('pan_card_id','<>',"");

		$g = $this->add('CRUD',['allow_add'=>false,'allow_del'=>false]);
		$g->setModel($model,['user','name','pan_no','pan_card_id']);
		$g->grid->addPaginator(100);

		$g->grid->setFormatter('pan_card_id','image');

	}
}