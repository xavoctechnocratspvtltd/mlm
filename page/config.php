<?php

namespace xavoc\mlm;

/**
* 
*/
class page_config extends \xepan\base\Page{

	public $title = "MLM Configuration";
	
	function init(){
		parent::init();

		$tab = $this->add('Tabs');
		
		$g_tab = $tab->addTab('Generation Income Slab');
		$g_crud = $g_tab->add('xepan\hr\CRUD');
		$g_crud->setModel('xavoc\mlm\GenerationIncomeSlab');
		
		$r_tab = $tab->addTab('RePurchase Bonus Slab');
		$r_crud = $r_tab->add('xepan\hr\CRUD');
		$r_crud->setModel('xavoc\mlm\RePurchaseBonusSlab');
	}
}