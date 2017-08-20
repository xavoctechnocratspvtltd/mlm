<?php

namespace xavoc\mlm;

class View_ItemStock extends \View{
	public $warehouse_id;

	function init(){
		parent::init();
		
		$show_form = true;
		if($this->warehouse_id)
			$show_form = false;

		$this->app->stickyGET('warehouse_id');
		if($_GET['warehouse_id'])
			$this->warehouse_id = $_GET['warehouse_id'];

		if($show_form){
			$f = $this->add('Form');
			$w_field = $f->addField('DropDown','warehouse');
			$w_field->setModel('xepan\commerce\Model_Store_Warehouse');
			$w_field->setEmptyText('Please Select');
		}

		$stock = $this->add('xavoc\mlm\Model_ItemStock');
		$grid = $this->add('Grid');
		if($this->warehouse_id){
			$stock->warehouse_id = $this->warehouse_id;
		}
		$stock->addCondition('net_stock','>',0);

		$grid->setModel($stock,['name_with_code','total_in','total_out','net_stock']);
		// $grid->addQuickSearch(['name_with_code']);
				
		if($show_form){
			$f->addSubmit('submit')->addClass('btn btn-primary')->setStyle('margin-top','10px');
			if($f->isSubmitted()){
				$grid->js()->reload(['warehouse_id'=>$f['warehouse']])->execute();
			}
		}


	}
}