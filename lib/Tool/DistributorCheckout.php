<?php

namespace xavoc\mlm;

/**
* 
*/
class Tool_DistributorCheckout extends \xavoc\mlm\Tool_Distributor{ 
	public $options = [];

	function init(){
		parent::init();

		if($this->owner instanceof \AbstractController) return;

		$this->addClass('main-box');

		$dist = $this->add('xavoc\mlm\Model_Distributor');
		$dist->loadLoggedIn();
		if(!$dist->loaded()){
			$this->add('View')->set("distributor not found, login first");
			return;
		}

		if($_GET['message']){
			$this->add('View')->addclass('alert alert-success text-center')->setElement('h4')->set($_GET['message']);
		}

		$temp = $this->add('xavoc\mlm\Model_TemporaryRepurchaseItem');
		$temp->addCondition('distributor_id',$dist->id);
		$total_cart_item = $temp->count()->getOne();
		// if(!$total_cart_item){
		// 	// $this->add('View')->set('cart is empty, cannot proceed further');
		// 	// return;
		// }

		$this->add('xavoc\mlm\View_Cart',['options'=>['show_clear_btn'=>false,'show_next_btn'=>false]]);
		$this->add('View')->setElement('hr');

		$crud = $this->add('CRUD',['allow_add'=>false,'allow_edit'=>true]);
		$crud->setModel($temp,['quantity'],['image','item','quantity','price']);
		$crud->grid->addHook('formatRow',function($m){
			$m->current_row_html['image'] = '<img class="checkout-item-image" style="height:100px;" src="'.$m['image'].'"/>';
		});	

		if($total_cart_item){
			$this->add('xavoc\mlm\View_RepurchasePaymentMode');
		}

	}
}