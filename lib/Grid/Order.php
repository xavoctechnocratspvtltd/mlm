<?php

namespace xavoc\mlm;

class Grid_Order extends \Grid{
	public $distributor;
	function init(){
		parent::init();

		$add_topup_btn = $this->addButton('Admin Topup')->addClass('btn btn-primary');
		$add_topup_btn->js('click')->univ()->frameURL('Add New Topup',$this->app->url('xavoc_dm_orderaction',['actiontype'=>'payment','distributor_id'=>$this->distributor->id]));

		$this->on('click','.do-ds-order',function($js,$data){
			$label = "Order Payment Verification";
			if($data['actiontype'] == 'dispatch')
				$label = "Order Dispatch";

			return $js->univ()->frameURL($label,$this->app->url('xavoc_dm_orderaction',['actiontype'=>$data['actiontype'],'istopuporder'=>$data['istopuporder'],'orderid'=>$data['orderid'],'distributor_id'=>$this->distributor->id]));
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
		parent::formatRow();
	}
}