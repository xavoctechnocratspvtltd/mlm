<?php


namespace xavoc\mlm;

class page_store extends \xepan\base\Page {
	public $title= "Store";

	function init(){
		parent::init();

		$this->setLeftMenu();
	}

	function setLeftMenu(){
		$this->app->side_menu->addItem(['Transaction','icon'=>'fa fa-circle-o','badge'=>[0,'swatch'=>' label label-primary label-circle pull-right']],$this->app->url('xavoc_dm_store_activity'))->setAttr(['title'=>'Store Transaction Activity']);
		// $this->app->side_menu->addItem(['Id Wise Sale','icon'=>'fa fa-circle-o','badge'=>[0,'swatch'=>' label label-primary label-circle pull-right']],$this->app->url('xavoc_dm_report_distributor'))->setAttr(['title'=>'Distributor Id wise sale report']);
		// $this->app->side_menu->addItem(['Dispatch Id wise','icon'=>'fa fa-circle-o','badge'=>[0,'swatch'=>' label label-primary label-circle pull-right']],$this->app->url('xavoc_dm_report_dispatch'))->setAttr(['title'=>'Distributor Report Id Wise']);
		
	}
}