<?php

namespace xavoc\mlm;

class Grid_Order extends \xepan\hr\Grid{
	public $distributor;
	function init(){
		parent::init();

		$this->addClass('ds-order-grid');
		$this->js('reload')->reload();

		$add_topup_btn = $this->addButton('Admin '.($this->istopuporder?'Topup':'Repurchase'))->addClass('btn btn-primary');
		$add_topup_btn->js('click')->univ()->frameURL('Add New Topup',$this->app->url('xavoc_dm_orderaction',['actiontype'=>'payment','distributor_id'=>$this->distributor->id,'istopuporder'=>$this->istopuporder]));

		$reload_url = $this->app->url(null,['cut_object'=>$this->name]);

		$this->on('click','.do-ds-order',function($js,$data){
			$label = "Order Payment Verification";
			if($data['actiontype'] == 'dispatch')
				$label = "Order Dispatch";

			return $js->univ()->frameURL($label,$this->app->url('xavoc_dm_orderaction',['actiontype'=>$data['actiontype'],'istopuporder'=>$data['istopuporder'],'orderid'=>$data['orderid'],'distributor_id'=>$this->distributor->id]));
		});

		$this->on('click','.do-ds-order-delete',function($js,$data)use($reload_url){
			$result = $this->add('xavoc\mlm\Model_SalesOrder')
				->load($data['orderid'])
				->deleteOrder();
			if($result){
				return $this->js(null,$this->js()->univ()->successMessage('order deleted'))->reload(null,null,$reload_url);
			}else{
				return $this->js()->univ()->errorMessage("not deleted");
			}
		});
		
	}

	function formatRow(){
		if(str_replace(" ", "", $this->model['invoice_detail']) == "0-none"){
			$this->current_row_html['invoice_detail'] = '<button class="btn btn-info do-ds-order" data-actiontype="payment" data-orderid="'.$this->model->id.'" data-istopuporder="'.$this->model['is_topup_included'].'">Verify Payment</button>';
		}else{
			$this->current_row_html['invoice_detail'] = '<div class="label label-success">'.$this->model['invoice_detail'].'</div>';
		}

		if($this->model['status'] == "Completed"){
			$this->current_row_html['status'] = '<div class="label label-success">'.$this->model['status'].'</div>';
		}else{
			$this->current_row_html['status'] = $this->model['status'].'<br/><button class="btn btn-info do-ds-order" data-actiontype="dispatch" data-orderid="'.$this->model->id.'">Dispatch</button>';
		}

		$this->current_row_html['remove'] = '<button class="btn btn-danger do-ds-order-delete" data-orderid="'.$this->model->id.'" >Delete</button>';
		parent::formatRow();
	}
}