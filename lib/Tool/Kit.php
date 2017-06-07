<?php

namespace xavoc\mlm;

/**
* Kit Lister
	Purchase kit directly and make order and redirect to payment gateway
*/
class Tool_Kit extends \xepan\cms\View_Tool{
	public $options = [
						'show_purchase_btn'=>true,
						'checkout_page'=>'payment'
					];

	public $complete_lister = null;
	function init(){
		parent::init();

		$kit_model = $this->add('xavoc\mlm\Model_Kit');
		// $kit_model->addCondition('status','Published');

		$layout_template = "kitlist";
		$this->complete_lister = $cl = $this->add('CompleteLister',null,null,['xavoc/tool/'.$layout_template]);
		$cl->setModel($kit_model);

		// deleting not found templates
		if($kit_model->count()->getOne()){
			$cl->template->del('not_found');
		}else{
			$cl->template->set('not_found_message','No Record Found');
		}

		$cl->add('xepan\cms\Controller_Tool_Optionhelper',['options'=>$this->options,'model'=>$kit_model]);


		$this->on('click','.xepan-di-kit-purchase-button',function($js,$data){
			$result = $this->placeOrder($data);

			if($result['status'] == "success"){
				$url = $this->app->url($this->options['checkout_page'],['order_id'=>$result['order_id'],'step'=>'complete','paid'=>true]);
				$js_event = [
					$js->univ()->redirect($url)
				]; 
				return $js->univ(null,$js_event)->successMessage($result['message']);
			}else{
				return $js->univ()->errorMessage($result['message']);
			}
		});
	}

	function addToolCondition_row_show_purchase_btn($value,$l){
		
		if($value != true){
			$l->current_row_html['purchase_btn_wrapper'] = "";
			return;
		}

		$btn = $l->add('Button',null,'purchase_btn');
		$btn->addClass('xepan-di-kit-purchase-button');
		$btn->setAttr('data-xbikitid',$l->model->id);
		$btn->set("Pay Now");
		$l->current_row_html['purchase_btn'] = $btn->getHtml();
	}

	function placeOrder($data){
		$result = ['status'=>'failed','message'=>'some thing gone wrong'];
		$kit_id = $data['xbikitid'];

		$kit_model = $this->add('xavoc\mlm\Model_Kit');
		$kit_model->tryLoad($kit_id);
		if(!$kit_model->loaded())
			throw new \Exception("kit not found", 1);
			

		$distributor = $this->add('xavoc\mlm\Model_Distributor');
		$distributor->loadLoggedIn();

		// return to login page
		if(!$distributor->loaded()){
			return ['status'=>'failed','message'=>'distributor not loaded'];
		}

		try{

			//Load Default TNC
			$tnc = $this->add('xepan\commerce\Model_TNC')->addCondition('is_default_for_sale_order',true)->setLimit(1)->tryLoadAny();
			$tnc_id = $tnc->loaded()?$tnc['id']:0;
			$tnc_text = $tnc['content']?$tnc['content']:"not defined";

			$master_detail = [
							'contact_id' => $distributor->id,
							'currency_id' => $distributor['currency_id']?$customer['currency_id']:$this->app->epan->default_currency->get('id'),
							'nominal_id' => 0,
							'billing_country_id'=> $distributor['billing_country_id']?:"0",
							'billing_state_id'=> $distributor['billing_state_id']?:"0",
							'billing_name'=> $distributor['billing_name']?:"not defined",
							'billing_address'=> $distributor['billing_address']?:"not defined",
							'billing_city'=> $distributor['billing_city']?:"not defined",
							'billing_pincode'=> $distributor['billing_pincode']?:"not defined",
							'shipping_country_id'=> $distributor['shipping_country_id']?:0,
							'shipping_state_id'=> $distributor['shipping_state_id']?:0,
							'shipping_name'=> $distributor['shipping_name']?:"not defined(name)",
							'shipping_address'=> $distributor['shipping_address']?:"not defined",
							'shipping_city'=> $distributor['shipping_city']?:"not defined",
							'shipping_pincode'=> $distributor['shipping_pincode']?:"not defined",
							'is_shipping_inclusive_tax'=> 0,
							'is_express_shipping'=> 0,
							'narration'=> null,
							'round_amount'=> 0,
							'discount_amount'=> 0, 
							'exchange_rate' => $this->app->epan->default_currency['value'],
							'tnc_id'=>$tnc_id,
							'tnc_text'=> $tnc_text,
							'status' => "OnlineUnpaid"
						];

			$detail_data = [];
			$taxation = $kit_model->applicableTaxation();
			if($taxation instanceof \xepan\commerce\Model_Taxation){
				$taxation_id = $taxation->id;
				$tax_percentage = $taxation['percentage'];
			}else{
				$taxation_id = 0;
				$tax_percentage = 0;
			}

			$qty_unit_id = $kit_model['qty_unit_id'];
			$item = [
				'item_id'=>$kit_model->id,
				'price'=>$kit_model['sale_price'],
				'quantity' => 1,
				'taxation_id' => $taxation_id,
				'tax_percentage' => $tax_percentage,
				'narration'=>null,
				'extra_info'=>"{}",
				'shipping_charge'=>0,
				'shipping_duration'=>0,
				'express_shipping_charge'=>0,
				'express_shipping_duration'=>null,
				'qty_unit_id'=>$qty_unit_id,
				'discount'=>0
			];

			$detail_data[] = $item;

			$qsp = $this->add('xepan\commerce\Model_QSP_Master')->createQSP($master_detail,$detail_data,'SalesOrder');

			$result = ['status'=>'success','message'=>'redirect to payment gateway please wait ...','order_id'=>$qsp['master_detail']['id']];

		}catch(\Exception $e){
			$result = ['status'=>'failed','message'=>$e->getMessage()];
		}

		return $result;
	}
}
						
