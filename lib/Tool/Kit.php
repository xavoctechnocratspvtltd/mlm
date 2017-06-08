<?php

namespace xavoc\mlm;

/**
* Kit Lister
	Purchase kit directly and make order and redirect to payment gateway
*/
class Tool_Kit extends \xepan\cms\View_Tool{
	public $options = [
						'show_purchase_btn'=>true,
						'checkout_page'=>'payment',
						'check_distributor'=>true
					];

	public $complete_lister = null;
	function init(){
		parent::init();


		// check distributor
		if($this->options['check_distributor']){
			$this->distributor = $distributor = $this->add('xavoc\mlm\Model_Distributor');
			$distributor->loadLoggedIn();
			if(!$distributor->loaded()){
				return "distributor not found";
			}
			if($distributor['kit_item_id']){
				$this->add('View')->set("Kit Purchased");
				$this->add('Button')->set('Go To DashBoard')->js('click')->redirect($this->app->url('dashboard'));
				return;
			}
		}


		$kit_model = $this->add('xavoc\mlm\Model_Kit');
		$kit_model->addCondition('status','Published');

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


		$vp = $this->add('VirtualPage');
		$vp->set(function($vp){
			$vp->app->stickyGET('kit_id');
			$kit_id = $_GET['kit_id'];
			$vp->add('xavoc\mlm\View_PaymentMode',['kit_id'=>$kit_id]);
		});

		$this->on('click','.xepan-di-kit-purchase-button',function($js,$data)use($vp){
			$js->univ()->frameURL('Select Payment Mode',$this->app->url($vp->getURL(),['kit_id'=>$data['xbikitid']]));
			// $result = $this->placeOrder($data);

			// if($result['status'] == "success"){
			// 	$url = $this->app->url($this->options['checkout_page'],['order_id'=>$result['order_id'],'step'=>'complete','paid'=>true]);
			// 	$js_event = [
			// 		$js->univ()->redirect($url)
			// 	]; 
			// 	return $js->univ(null,$js_event)->successMessage($result['message']);
			// }else{
			// 	return $js->univ()->errorMessage($result['message']);
			// }
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

	
}
						
