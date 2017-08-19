<?php


namespace xavoc\mlm;

class page_storetransaction extends \xepan\base\Page {
	public $title= "Store Transaction";
	
	function init(){
		parent::init();

		$this->add('xavoc\mlm\View_StoreTransaction');
	}
}