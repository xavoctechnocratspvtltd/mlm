<?php


namespace xavoc\mlm;

class page_itemstock extends \xepan\base\Page {
	public $title= "Item Stock";
	
	function init(){
		parent::init();

		$this->add('xavoc\mlm\View_ItemStock');
	}
}