<?php

namespace xavoc\mlm;

class View_Cart extends \View{

	public $options= [
				'checkout_page'=>'repurchasecheckout',
				'show_next_btn'=>true,
				'show_clear_btn'=>true,
				'show_continue_shopping_btn'=>false,
			];

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

		$total_cart_item = $temp->count()->getOne();

		$col = $this->add('Columns')->addClass('row');
		$col1 = $col->addColumn(4)->addClass('col-lg-6 col-md-6 col-sm-12 col-xs-12');
		$col2 = $col->addColumn(4)->addClass('col-lg-3 col-md-3 col-sm-12 col-xs-12');
		$col3 = $col->addColumn(4)->addClass('col-lg-3 col-md-3 col-sm-12 col-xs-12');

		$col1->add('View')->setHtml('<i class="glyphicon glyphicon-shopping-cart fa-3x text-info"></i> <i class="fa fa-2x">'.$total_cart_item."</i> - <i class='fa fa-rupee fa-2x text-success'> ".($temp->sum($temp->getElement('amount'))->getOne()?:0)."</i>");
		if($this->options['show_clear_btn']){
			$clear_btn = $col2->add('Button')->setHtml('<b>Clear Cart</b>')->addClass('btn btn-danger btn-block');
			if($clear_btn->isClicked()){
				$temp->deleteAll();
				$clear_btn->js(true,$this->js()->reload())->univ()->successMessage('your cart is empty')->execute();
			}
		}

		if($this->options['show_next_btn']){
			$next_btn = $col3->add('Button')->setHtml('<b>Next</b>')->addClass('btn ds-bg-orange btn-block');
			if($next_btn->isClicked()){
				if(!$total_cart_item)
					$next_btn->js()->univ()->errorMessage('add item to your cart')->execute();
				
				$next_btn->js()->univ()->redirect('repurchasecheckout')->execute();
			}
		}else{
			$continue_shopping_btn = $col3->add('Button')->setHtml('<b>Continue Shopping</b>')->addClass('btn ds-bg-orange btn-block');
			if($continue_shopping_btn->isClicked()){
				$continue_shopping_btn->js()->univ()->redirect('repurchase')->execute();
			}
		}
		

	}
};