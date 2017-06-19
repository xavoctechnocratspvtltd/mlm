<?php


namespace xavoc\mlm;

class page_closings extends \xepan\base\Page {
	public $title= "Closings";

	function init(){
		parent::init();

		$tabs = $this->add('Tabs');
		$dt = $tabs->addTab('Daily');
		$wt = $tabs->addTab('Weekly');
		$mt = $tabs->addTab('Monthly');

		$crud = $dt->add('xepan\hr\CRUD',['allow_del'=>false,'allow_edit'=>false]);
		$crud->setModel('xavoc\mlm\Model_Closing_Daily');

		$crud = $wt->add('xepan\hr\CRUD',['allow_del'=>false,'allow_edit'=>false]);
		$crud->setModel('xavoc\mlm\Model_Closing_Weekly');

		$crud = $mt->add('xepan\hr\CRUD',['allow_del'=>false,'allow_edit'=>false]);
		$crud->setModel('xavoc\mlm\Model_Closing_Monthly');

	}

}