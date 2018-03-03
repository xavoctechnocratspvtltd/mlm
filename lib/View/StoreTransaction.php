<?php

namespace xavoc\mlm;

class View_StoreTransaction extends \View{
	public $warehouse;

	function init(){
		parent::init();

		$from_date = $this->app->stickyGET('from_date')?:$this->app->today;
		$to_date = $this->app->stickyGET('to_date')?:$this->app->today;

		$form = $this->add('Form');
		$form->add('xepan\base\Controller_FLC')
			->showLables(true)
			->makePanelsCoppalsible(true)
			->layout([
					'from_date'=>'filter~c1~4',
					'to_date'=>'c2~4',
					'FormButtons~&nbsp;'=>'c3~4'
				]);

		$form->addField('DatePicker','from_date')->set($from_date);
		$form->addField('DatePicker','to_date')->set($to_date);
		$form->addSubmit('Filter')->addClass('btn btn-primary');

		$transaction = $this->add('xepan\commerce\Model_Store_TransactionAbstract');
		$transaction->addCondition('type',['Purchase','Received','Movement','PackageCreated','PackageOpened','ConsumedInPackage','ReleaseFromPackage','Store_Transaction','Store_Delivered']);

		$transaction->addExpression('total_item')->set(function($m,$q){
			$to_received = $m->refSQL('StoreTransactionRows')
							->count();
			return $q->expr("IFNULL ([0], 0)",[$to_received]);
		})->sortable(true);

		if($this->warehouse){
			$transaction->addCondition([['from_warehouse_id',$this->warehouse],['to_warehouse_id',$this->warehouse]]);
		}
		$transaction->setOrder('id','desc');

		if($from_date AND $to_date){
			$transaction->addCondition('created_at','>=',$from_date);
			$transaction->addCondition('created_at','<',$this->app->nextDate($to_date));
		}

		$grid = $this->add('xepan\base\Grid');
		$grid->setModel($transaction,['from_warehouse','to_warehouse','type','created_at','narration','total_item','item_quantity']);
		$grid->addSno('Sr. No.');
		$grid->addPaginator(25);

		$grid->add('VirtualPage')
		->addColumn('detail')
		->set(function($page){

			$id = $_GET[$page->short_name.'_id'];
			// $page->add('View')->set("hello ".$id." ".$page->short_name);
			$detail = $this->add('xepan\commerce\Model_Store_TransactionRow');
			$detail->addCondition('store_transaction_id',$id);

			$grid = $page->add('Grid');
			$grid->setModel($detail,['item_name','quantity']);
		});


		if($form->isSubmitted()){
			$grid->js()->reload(['from_date'=>$form['from_date'],'to_date'=>$form['to_date']])->execute();
		}
	}
}