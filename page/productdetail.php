<?php

namespace xavoc\mlm;

class page_productdetail extends \Page {
	public $commerce_item_id;

	function init(){
		parent::init();
		
		// $this->addClass('ds-product-detail');

		if(!$this->app->auth->model->loaded()){
			throw new \Exception("you are not the authorize person to view this page ...");
		}

		if($this->commerce_item_id){
			$this->add('View')->set('no product found to display')->addClass("alert alert-danger");
			return;
		}

		$col = $this->add('Columns');
		$img_col = $col->addColumn('6')->addClass('col-md-4 col-lg-4 col-sm-12 col-xs-12')->addStyle('padding-top','50px');
		$detail_col = $col->addColumn('6')->addClass('col-md-8 col-lg-8 col-sm-12 col-xs-12');
		
		$options = [
				'zoom-type'=>"window",
				'zoom-window-position'=>0,
				'zoom-effect'=>true
			];
		$img_col->add('xepan\commerce\Tool_ItemImage',['options'=>$options]);

		$options= [
				'layout'=>'flat',/*flat,collapse,tab,primary*/
				'specification_layout'=>'specification',
				'show_item_upload'=>false,
				'show_addtocart'=>true,
				'show_multi_step_form'=>false,
				'multi_step_form_layout'=>"stacked",
				'custom_template'=>"",
				'personalized_page'=>"",
				'personalized_button_label'=>"Personalized",
				'addtocart_button_label'=>'Add To Cart',
				'show_price_or_amount'=>false,
				"show_original_price"=>true, // sale Price, sale/Original Price
				"show_shipping_charge"=>false,
				"shipping_charge_with_item_amount"=>false,
				"checkout_page"=>"",
				'continue_shopping_page'=>"index",
				'amount_group_in_multistepform'=>null
			];

		$detail_col->add('xepan\commerce\Tool_Item_Detail',['options'=>$options]);

	}
}