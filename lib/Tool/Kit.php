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
						'check_distributor'=>true,
						'show_image'=>true,
						'show_description'=>true,
						'paginator_set_rows_per_page'=>20
					];

	public $complete_lister = null;
	function init(){
		parent::init();

		if($this->owner instanceof \AbstractController) return;

		$this->addClass('ds-kitlist main-box');
		$layout_template = "kitlist";
		
		// check distributor
		if($this->options['check_distributor']){
			$this->distributor = $distributor = $this->add('xavoc\mlm\Model_Distributor');
			$distributor->loadLoggedIn();
			if(!$distributor->loaded()){
				return "distributor not found";
			}
			if($distributor['kit_item_id'] ){
				$this->add('View')->setHtml("<p style='font-size:20px;'>Select Package & Update Your Topup</p>")->addClass('text-center alert alert-info')->setStyle(['font-weight'=>'bold']);
			}
		}


		$kit_model = $this->add('xavoc\mlm\Model_Kit');
		$kit_model->addExpression('capping_int')->set(function($m,$q){
			return $q->expr('CAST([0] AS SIGNED)',[$m->getElement('capping')]);
		});

		$kit_model->addCondition('status','Published');

		if($distributor['kit_item_id']){
			$last_kit = $this->add('xavoc\mlm\Model_TopupHistory')
						->addCondition('distributor_id',$distributor->id)
						->setOrder('id','desc')
						->tryLoadAny()
						;
			if($last_kit->loaded())
				$kit_model->addCondition('capping_int','>',$last_kit['capping']);
			else{
				$kit_model->addCondition('capping_int','>',$distributor['capping']);
			}
		}

		$this->complete_lister = $cl = $this->add('CompleteLister',null,null,['xavoc/tool/'.$layout_template]);
		$cl->setModel($kit_model);
		$paginator = $cl->add('Paginator',['ipp'=>$this->options['paginator_set_rows_per_page']]);
		$paginator->setRowsPerPage($this->options['paginator_set_rows_per_page']);

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
		$btn->addClass('xepan-di-kit-purchase-button btn btn-primary btn-block');
		$btn->setAttr('data-xbikitid',$l->model->id);
		$btn->set("Purchase Now");
		$l->current_row_html['purchase_btn'] = $btn->getHtml();
	}

	function addToolCondition_row_show_image($value,$l){
		if($value != true){
			$l->current_row_html['image_wrapper'] = "";
			return;
		}

		$l->current_row_html['kit_img'] = $l->model['first_image']?:"shared/apps/xavoc/mlm/templates/img/100.svg";
	}
	
	function addToolCondition_row_show_description($value,$l){
		if(!$value){
			$l->current_row_html['description']='';
			return;
		}
		if($this->options['show_description']){
			$l->current_row_html['description']=$l->model['description'];
		}else{
			$l->current_row_html['description']=" ";
		}
	}
}	
						
