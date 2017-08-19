<?php

namespace xavoc\mlm;

class View_StoreTransaction extends \View{
	public $warehouse;

	function init(){
		parent::init();

		$transaction = $this->add('xepan\commerce\Model_Store_TransactionAbstract');
		$transaction->addCondition('type',['Purchase','Received','Movement','PackageCreated','PackageOpened','ConsumedInPackage','ReleaseFromPackage','Store_Transaction']);

		if($this->warehouse){
			$transaction->addCondition([['from_warehouse_id',$this->warehouse],['to_warehouse_id',$this->warehouse]]);
		}

		$grid = $this->add('Grid');
		$grid->setModel($transaction,['from_warehouse','to_warehouse','type','created_at','narration','item_quantity']);

		$grid->add('VirtualPage')
		->addColumn('detail')
		->set(function($page){
			$id = $_GET[$page->short_name.'_id'];
			$detail = $this->add('xepan\commerce\Model_Store_TransactionRow');
			$detail->addCondition('store_transaction_id',$id);

			$grid = $page->add('Grid');
			$grid->setModel($detail,['item_name','quantity']);
		});
	}
}