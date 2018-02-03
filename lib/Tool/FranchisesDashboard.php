<?php

namespace xavoc\mlm;

class Tool_FranchisesDashboard extends \xepan\cms\View_Tool{
	public $options = [];

	function init(){
		parent::init();
		
		if($this->owner instanceof \AbstractController) return;
		
		$this->addClass('main-box');
		$this->franchises = $franchises = $this->add('xavoc\mlm\Model_Franchises');
		$franchises->loadLoggedIn();

		// $this->add('View')->set("we are working on it ... features are comming soon");

		$col = $this->add('Columns');
		$col1 = $col->addColumn(4)->addClass('col-md-4');
		$col2 = $col->addColumn(4)->addClass('col-md-4');
		$col3 = $col->addColumn(4)->addClass('col-md-4');
		
		$oh = $this->add('xavoc\mlm\Model_SalesOrder');
		$oh->addCondition('created_by_id',$this->franchises->id);

		$card = $col1->add('xavoc\mlm\View_Card',
						[
							'options'=>[
								'header'=>'Total Order Created by You',
								'title'=>$oh->count()->getOne(),
								'theme'=>'orange',
							]
						]);


		// $card = $col2->add('xavoc\mlm\View_Card',
		// 				[
		// 					'options'=>[
		// 						'header'=>'Total Amount to Submit',
		// 						'title'=>'',
		// 						'theme'=>'red',
		// 					]
		// 				]);
		
		$today_order = $this->add('xavoc\mlm\Model_SalesOrder');
		$today_order->addCondition('created_by_id',$this->franchises->id);
		$today_order->addCondition('created_at','>',$this->app->today);
		$today_order->addCondition('created_at','<=',$this->app->nextDate($this->app->today));
		
		$card = $col2->add('xavoc\mlm\View_Card',
						[
							'options'=>[
								'header'=>'Today New Orders',
								'title'=>$today_order->count()->getOne(),
								'theme'=>'green',
							]
						]);
	}
}