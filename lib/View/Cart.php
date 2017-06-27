<?php

namespace xavoc\mlm;

class View_Cart extends \View{

	public $options= [];

	function init(){
		parent::init();

		$dist = $this->add('xavoc\mlm\Model_Distributor');
		$dist->loadLoggedIn();
		if(!$dist->loaded()){
			$this->add('View')->set("distributor not found, login first");
			return;
		}


		$temp = $this->add('xavoc\mlm\Model_TemporaryRepurchaseItem');
		$temp->addCondition('distributor_id',$dist->id);

		$col = $this->add('Columns')->addClass('row');
		$col1 = $col->addColumn(4)->addClass('col-lg-6 col-md-6 col-sm-12 col-xs-12');
		$col2 = $col->addColumn(4)->addClass('col-lg-3 col-md-3 col-sm-12 col-xs-12');
		$col3 = $col->addColumn(4)->addClass('col-lg-3 col-md-3 col-sm-12 col-xs-12');

		$col1->add('View')->setHtml('<i class="glyphicon glyphicon-shopping-cart fa-3x text-info"></i> <i class="fa fa-2x">'.$temp->count()->getOne()."</i> - <i class='fa fa-rupee fa-2x text-success'> ".($temp->sum('price')->getOne()?:0)."</i>");
		$clear_btn = $col2->add('Button')->setHtml('<b>Clear</b>')->addClass('btn btn-danger btn-block');
		$next_btn = $col3->add('Button')->setHtml('<b>Next</b>')->addClass('btn ds-bg-orange btn-block');
		
		if($clear_btn->isClicked()){
			$temp->deleteAll();
			$clear_btn->js(true,$this->js()->reload())->univ()->successMessage('your cart is empty')->execute();
		}

	}
};