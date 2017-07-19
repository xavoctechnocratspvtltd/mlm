<?php


namespace xavoc\mlm;

class page_report extends \xepan\base\Page {
	public $title= "Reports";

	function init(){
		parent::init();

		$this->setLeftMenu();
	}

	function setLeftMenu(){
		$this->app->side_menu->addItem(['Plan Wise Sale','icon'=>'fa fa-circle-o','badge'=>[0,'swatch'=>' label label-primary label-circle pull-right']],$this->app->url('xavoc_dm_report_planwisesale'))->setAttr(['title'=>'Plan wise sale report']);
		$this->app->side_menu->addItem(['Id Wise Sale','icon'=>'fa fa-circle-o','badge'=>[0,'swatch'=>' label label-primary label-circle pull-right']],$this->app->url('xavoc_dm_report_distributor'))->setAttr(['title'=>'Distributor Id wise sale report']);
		$this->app->side_menu->addItem(['Dispatch Id wise','icon'=>'fa fa-circle-o','badge'=>[0,'swatch'=>' label label-primary label-circle pull-right']],$this->app->url('xavoc_dm_report_dispatch'))->setAttr(['title'=>'Distributor Report Id Wise']);
		// $this->app->side_menu->addItem(['Franchises Sale','icon'=>'fa fa-shopping-cart text-success','badge'=>[0,'swatch'=>' label label-primary label-circle pull-right']],$this->app->url('xepan_dm_report_franchisessale'))->setAttr(['title'=>'Franchises Sales Report']);
	
	}
}