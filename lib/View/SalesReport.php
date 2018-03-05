<?php

namespace xavoc\mlm;

class View_SalesReport extends \View{
	public $from_warehouse_id = null;

	function init(){
		parent::init();

		if(!$this->from_warehouse_id){
			$this->add('View')->addClass('alert alert-warning')->set('must pass from warehouse id');
			return;
		}

		$from_date = $this->app->stickyGET('from_date')?:$this->app->today;
		$to_date = $this->app->stickyGET('to_date')?:$this->app->today;

		$form = $this->add('Form');
		$form->add('xepan\base\Controller_FLC')
				->showLables(true)
				->makePanelsCoppalsible(true)
				->layout([
						'from_date'=>'Filter~c1~4',
						'to_date'=>'c2~4',
						'FormButtons~&nbsp;'=>'c3~4',
					]);						
		$form->addField('DatePicker','from_date')->set($from_date);
		$form->addField('DatePicker','to_date')->set($to_date);
		$form->addSubmit('Filter');

		$row = $this->add('xepan\commerce\Model_Store_TransactionRow');
		$row->addExpression('from_warehouse_id')->set($row->refSql('store_transaction_id')->fieldQuery('from_warehouse_id'));

		$row->addExpression('bv')->set(function($m,$q){
			$item = $m->add('xavoc\mlm\Model_Item',['table_alias'=>'mbv']);
			$item->addCondition('id',$m->getElement('item_id'));
			return $q->expr('IFNULL([0],0)',[$item->fieldQuery('bv')]);
		});

		$row->addExpression('pv')->set(function($m,$q){
			$item = $m->add('xavoc\mlm\Model_Item',['table_alias'=>'mpv']);
			$item->addCondition('id',$m->getElement('item_id'));
			return $q->expr('IFNULL([0],0)',[$item->fieldQuery('pv')]);
		});

		$row->addExpression('sv')->set(function($m,$q){
			$item = $m->add('xavoc\mlm\Model_Item',['table_alias'=>'msv']);
			$item->addCondition('id',$m->getElement('item_id'));
			return $q->expr('IFNULL([0],0)',[$item->fieldQuery('sv')]);
		});

		$row->addExpression('dp')->set(function($m,$q){
			$item = $m->add('xavoc\mlm\Model_Item',['table_alias'=>'mdp']);
			$item->addCondition('id',$m->getElement('item_id'));
			return $q->expr('IFNULL([0],0)',[$item->fieldQuery('dp')]);
		});		

		$row->addCondition('type','Store_Delivered');
		$row->addCondition('from_warehouse_id',$this->from_warehouse_id);
		$row->addCondition('created_at','>=',$from_date);
		$row->addCondition('created_at','<',$this->app->nextDate($to_date));
		
		$grid = $this->add('xepan\base\Grid');
		$grid->setModel($row,['store_transaction_id','created_at','item','item_id','quantity','bv','pv','sv','dp']);
		
		$grid->addTotals(['sv','pv','dp','bv']);

		if($form->isSubmitted()){
			$grid->js()->reload(['from_date'=>$form['from_date'],'to_date'=>$form['to_date']])->execute();
		}
	}
}