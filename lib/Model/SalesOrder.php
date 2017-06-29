<?php

namespace xavoc\mlm;

class Model_SalesOrder extends \xepan\commerce\Model_SalesOrder {
	public $table_alias =  'mlm_sale_order';
	public $status = ['Draft','Submitted','Redesign','Approved','InProgress','Canceled','Completed','Dispatched','OnlineUnpaid'];
	public $actions = [

	'Draft'=>['view','edit','delete','manage_attachments','verifyRepurchasePayment'],
	'Submitted'=>['view','edit','delete','approve','redesign','manage_attachments','print_document','verifyRepurchasePayment'],
	'Approved'=>['view','edit','delete','inprogress','send','manage_attachments','createInvoice','print_document'],
	'InProgress'=>['view','edit','delete','cancel','complete','manage_attachments','send'],
	'Canceled'=>['view','edit','delete','redraft','manage_attachments'],
	'Completed'=>['view','edit','delete','manage_attachments','createInvoice','print_document','send'],
	'OnlineUnpaid'=>['view','edit','delete','approve','createInvoice','manage_attachments','print_document','send','verifyRepurchasePayment'],
	'Redesign'=>['view','edit','delete','submit','manage_attachments']
	];
	/*
		['Draft'] => no used
		['Submitted'] => if online then invoice paid for this order else no invoice only order submitted
		['Approved'] => not used
		['InProgress'] => not used
		['completed'] => only dispatched
		['onlineUnpaid'] => order confirmed but could not be paid
	*/

	function init(){
		parent::init();

		$this->addExpression('is_topup_included')->set(function($m,$q){
			return $q->expr('IFNULL([0],0)',[$m->refSQL('xavoc\mlm\Model_QSPDetail')->sum('is_package')]);
		});
		
		$this->addExpression('items')->set($this->refSQL('Details')->count());
		$this->addExpression('invoice_detail')->set(function($m,$q){
			$in = $m->add('xepan\commerce\Model_SalesInvoice');
			$in->addCondition('related_qsp_master_id',$q->getField('id'));

			return $q->expr("CONCAT(IFNULL([0],'0'),'-',IFNULL([1],'none'))",[$in->fieldQuery('id'),$in->fieldQuery('status')]);
		})->caption('Invoice/Status');

		$this->hasMany('xavoc\mlm\Model_QSPDetail','qsp_master_id');
	}

	function verifyRepurchasePayment(){
		if(!$this->loaded()) $this->throw('sale ordre model not loaded')->addMoreInfo('in mlm sale order');
		// mark order invoice and paid invoice
		// distribute repurchase value
		// mark order complete and dispatch the goods
		$sale_invoice = $this->invoice();
		$sale_invoice->paid();
		$this->complete();
	}

	function deleteOrder(){
		
		// delete invoice  and delete
		// topup history
		// delete repurchase history
		// update repurchase with negative bv or sv
		try{
			$this->app->db->beginTransaction();

			$temp_array = explode("-", $this['invoice_detail']);
			if($temp_array[0] > 0){
				$this->invoice()->delete();
			}

			if($this['is_topup_included']){
				$th = $this->add('xavoc\mlm\Model_TopupHistory');
				$th->addCondition('distributor_id',$this['contact_id']);
				$th->addCondition([['sale_order_id',$this->id],['sale_order_id','<>',null]]);
				$th->tryLoadAny()->delete();
			}

			if(!$this['is_topup_included']){
				$rh = $this->add('xavoc\mlm\Model_RepurchaseHistory');
				$rh->addCondition('distributor_id',$this['contact_id']);
				$rh->addCondition([['sale_order_id',$this->id],['sale_order_id','<>',null]]);
				$rh->tryLoadAny()->delete();
			}

			$total_bv = 0;
			$total_sv = 0;
			foreach ($this->items() as $oi) {
		        $item = $this->add('xavoc\mlm\Model_Item')->load($oi['item_id']);
				$total_bv += $item['bv']*$oi['quantity'];
		        $total_sv += $item['sv']*$oi['quantity'];
		    }

		    if($total_bv > 0 || $total_sv > 0){
		    	$dis = $this->add('xavoc\mlm\Model_Distributor');
		    	$dis->load($this['contact_id']);
		    	if($total_sv > 0){
		    		$dis->updateAnsestorsSV(-1 * $total_sv);
		    	}
				
				if($total_bv > 0){
		    		$dis['month_self_bv'] = $dis['month_self_bv'] - $total_bv;
					$dis['total_self_bv'] = $dis['total_self_bv'] - $total_bv;
					$dis->save();
					$dis->updateAnsestorsBV(-1 * $total_bv);
				}
		    }
			
			$this->delete();
			$this->app->db->commit();
		}catch(\Exception $e){
			$this->app->db->rollback();
			throw $e;
		}

		return true;
	}
} 