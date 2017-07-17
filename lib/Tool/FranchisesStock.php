<?php

namespace xavoc\mlm;

class Tool_FranchisesStock extends \xepan\cms\View_Tool{
	public $options = [];

	function init(){
		parent::init();
		
		if($this->owner instanceof \AbstractController) return;

		$this->addClass('main-box');

		$this->franchises = $franchises = $this->add('xavoc\mlm\Model_Franchises');
		$franchises->loadLoggedIn();

		$grid = $this->add('xepan\base\Grid');
		$model = $this->add('xepan\commerce\Model_Item_Stock',['warehouse_id'=>$franchises->id]);
		$model->addExpression('product')->set(function($m,$q){
			return $q->expr('CONCAT([0]," :: ",[1]," :: ",IFNULL([2]," "))',[$m->getElement('name'),$m->getElement('sku'),$m->getElement('hsn_sac')]);
		});

		$model->addCondition('net_stock','>',0);

		$grid->setModel($model,['product','net_stock','qty_unit']);
		// $grid->setModel($model,['name','opening','purchase','purchase_return','consumption_booked','consumed','received','adjustment_add','adjustment_removed','movement_in','movement_out','sales_return','shipped','delivered','package_created','package_opened','consumed_in_package','release_from_package','net_stock','qty_unit']);
		$grid->addPaginator(50);
		$grid->addQuickSearch(['name']);
	}
}