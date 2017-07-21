<?php

namespace xavoc\mlm;

class Tool_FranchisesDashboard extends \xepan\cms\View_Tool{
	public $options = [];

	function init(){
		parent::init();
		
		if($this->owner instanceof \AbstractController) return;
		
		$this->addClass('main-box');
		$this->add('View')->set("we are working on it ... features are comming soon");

		$col = $this->add('Columns');
		$col1 = $col->addColumn(4)->addClass('col-md-4');
		$col2 = $col->addColumn(4)->addClass('col-md-4');
		$col3 = $col->addColumn(4)->addClass('col-md-4');
		
		$card = $col1->add('xavoc\mlm\View_Card',
						[
							'options'=>[
								'header'=>'Total Order',
								'title'=>'',
								'theme'=>'orange',
							]
						]);

		$card = $col2->add('xavoc\mlm\View_Card',
						[
							'options'=>[
								'header'=>'Total Amount to Submit',
								'title'=>'',
								'theme'=>'red',
							]
						]);

		$card = $col3->add('xavoc\mlm\View_Card',
						[
							'options'=>[
								'header'=>'Today New Orders',
								'title'=>'',
								'theme'=>'green',
							]
						]);
	}
}