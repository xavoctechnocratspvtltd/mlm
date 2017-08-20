<?php

namespace xavoc\mlm;

class View_StoreTransaction extends \View{
	public $warehouse;

	function init(){
		parent::init();

		$transaction = $this->add('xepan\commerce\Model_Store_TransactionAbstract');
		$transaction->addCondition('type',['Purchase','Received','Movement','PackageCreated','PackageOpened','ConsumedInPackage','ReleaseFromPackage','Store_Transaction']);

		$transaction->addExpression('total_item')->set(function($m,$q){
			$to_received = $m->refSQL('StoreTransactionRows')
							->count();
			return $q->expr("IFNULL ([0], 0)",[$to_received]);
		})->sortable(true);

		if($this->warehouse){
			$transaction->addCondition([['from_warehouse_id',$this->warehouse],['to_warehouse_id',$this->warehouse]]);
		}
		$transaction->setOrder('id','desc');

		$grid = $this->add('xepan\base\Grid');
		$grid->setModel($transaction,['from_warehouse','to_warehouse','type','created_at','narration','total_item','item_quantity']);
		$grid->addSno('Sr. No.');

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
	}
}