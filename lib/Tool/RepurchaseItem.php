<?php

namespace xavoc\mlm;

class Tool_RepurchaseItem extends \xepan\cms\View_Tool{
	public $options = [
					'show_addtocart'=>true,
					'checkout_page'=>'payment',
					'check_distributor'=>true,
					'show_image'=>true,
					'show_description'=>true,
					'paginator_set_rows_per_page'=>16
				];
	public $complete_lister = null;

	function init(){
		parent::init();

		if($this->owner instanceof \AbstractController) return;

		$this->addClass('ds-repurchase-list main-box');
		$layout_template = "repurchaseitemlist";
		
		// check distributor
		$this->distributor = $distributor = $this->add('xavoc\mlm\Model_Distributor');
		$distributor->loadLoggedIn();
		if(!$distributor->loaded()){
			return "distributor not found";
		}

		$repurchase_item = $this->add('xavoc\mlm\Model_RepurchaseItem');
		$repurchase_item->addCondition('status','Published');

		$repurchase_item->addExpression('taxed_price')->set(function($m,$q){
			return $q->expr('ROUND([price]+([price]*IFNULL([tax_percenatge],0)/100),2)',[
					'price'=>$m->getElement('dp'),
					'tax_percenatge'=>$m->getElement('tax_percentage')
				]);
		});

		$this->complete_lister = $cl = $this->add('CompleteLister',null,null,['xavoc/tool/'.$layout_template]);
		$cl->setModel($repurchase_item);
		$paginator = $cl->add('Paginator',['ipp'=>$this->options['paginator_set_rows_per_page']]);
		$paginator->setRowsPerPage($this->options['paginator_set_rows_per_page']);

		// deleting not found templates
		if($repurchase_item->count()->getOne()){
			$cl->template->del('not_found');
		}else{
			$cl->template->set('not_found_message','No Record Found');
		}

		$cl->add('xepan\cms\Controller_Tool_Optionhelper',['options'=>$this->options,'model'=>$repurchase_item]);

		// cart tool
		$this->cart = $cl->add('xavoc\mlm\View_Cart',null,'heading');

		$this->on('click','.img-wrapper,.caption > h3',function($js,$data){

			return $js->univ()->frameURL("Product Detail: ".$data['name'],$this->app->url('xavoc_dm_productdetail',['commerce_item_id'=>$data['itemid']]));
		});
	}

	function addToolCondition_row_show_addtocart($value,$l){
		if($value != true){
			$l->current_row_html['addtocart_wrapper'] = "";
			return;
		}

		$form = $l->add('Form',['name'=>'f_'.$l->model->id],'addtocart');

		$col = $form->add('Columns')->addClass('row');
		$col1 = $col->addColumn(4)->addClass('col-lg-12 col-md-12 col-sm-12 col-xs-12');
		$col2 = $col->addColumn(8)->addClass('col-lg-12 col-md-12 col-sm-12 col-xs-12');
		$col1->addField('Number','qty')->set(1)->validate('required');
		$col1->addField('hidden','item_id')->set($l->model->id);
		$col1->addField('hidden','price')->set($l->model['dp']);
		$col2->addSubmit('Add To Cart')->addClass('btn btn-primary btn-block');

		if($form->isSubmitted()){
			$temp = $this->add('xavoc\mlm\Model_TemporaryRepurchaseItem');
			$temp['distributor_id'] = $this->distributor->id;
			$temp['item_id'] = $form['item_id'];
			$temp['quantity'] = $form['qty'];
			$temp['price'] = $form['price'];
			$temp->save();

			$form->js(null,$this->cart->js()->reload())->univ()->successMessage('item added to cart')->execute();
		}
		$l->current_row_html['addtocart'] = $form->getHtml();
	}

	function addToolCondition_row_show_image($value,$l){
		
		if($value != true){
			$l->current_row_html['image_wrapper'] = "";
			return;
		}
		$l->current_row_html['img'] = $l->model['first_image']?:"shared/apps/xavoc/mlm/templates/img/100.svg";
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
						
