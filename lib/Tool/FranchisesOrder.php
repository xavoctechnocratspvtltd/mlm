<?php

namespace xavoc\mlm;

class Tool_FranchisesOrder extends \xepan\cms\View_Tool{
	public $options = [];

	function init(){
		parent::init();
		
		$sale_order = $this->add('xavoc\mlm\Model_SalesOrder');
		$this->addClass('main-box');
		$grid = $this->add('xepan\base\Grid');
		$grid->setModel($sale_order,['document_no','contact','net_amount']);
		$grid->addPaginator($ipp=50);

	}
}