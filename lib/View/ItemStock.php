<?php

namespace xavoc\mlm;

class View_ItemStock extends \View{

	function init(){
		parent::init();	

		$this->app->stickyGET('warehouse_id');

		$f = $this->add('Form');
		// $col = $f->add('Columns')->addClass('row');
		// $col1 = $col->addColumn('8')->addClass('col-md-8 col-lg-8 col-sm-12 col-xs-12');
		// $col2 = $col->addColumn('4')->addClass('col-md-4 col-lg-4 col-sm-12 col-xs-12');

		$w_field = $f->addField('DropDown','warehouse');
		$w_field->setModel('xepan\commerce\Model_Store_Warehouse');
		$w_field->setEmptyText('Please Select');

		$stock = $this->add('xavoc\mlm\Model_ItemStock');
		$grid = $this->add('Grid');
		if($_GET['warehouse_id']){
			$stock->warehouse_id = $_GET['warehouse_id'];
		}
		$stock->addCondition('net_stock','>',0);

		$grid->setModel($stock,['name_with_code','total_in','total_out','net_stock']);

		$f->addSubmit('submit')->addClass('btn btn-primary')->setStyle('margin-top','10px');

		if($f->isSubmitted()){
			$grid->js()->reload(['warehouse_id'=>$f['warehouse']])->execute();
		}

	}
}