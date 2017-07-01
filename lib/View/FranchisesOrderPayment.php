<?php

namespace xavoc\mlm;

class View_FranchisesOrderPayment extends \View{

	public $saleOrder;
	public $reload_view;
	function init(){
		parent::init();

		if(!$this->saleOrder->loaded()) throw new \Exception("saleorder must pass");

		$f_model = $this->add('xavoc\mlm\Model_Franchises');
		$f_model->loadLoggedIn();
		if(!$f_model->loaded()){
			$this->add('View')->set('you are not a franchises or your session is out');
			return;
		}

		$f = $this->add('Form');
		$f->addField('text','narration')->validate('required');
		$f->addSubmit('Payment Received')->addClass('btn btn-primary');

		if($f->isSubmitted()){

			try{

				$this->app->db->beginTransaction();
				$oi = $this->saleOrder->orderItems()->tryLoadAny();
				$kit_id = $oi['item_id'];

				$history = $this->add('xavoc\mlm\Model_TopupHistory');
				if(!$this->saleOrder['is_topup_included']){
					$history = $this->add('xavoc\mlm\Model_RepurchaseHistory');
				}

				$history->addCondition('distributor_id',$this->saleOrder['contact_id']);
				$history->addCondition('sale_order_id',$this->saleOrder->id);
				$history->tryLoadAny();

				$history['payment_narration'] = $f['narration'];
				$history['payment_mode'] = 'deposite_in_franchies';
				$history['is_payment_verified'] = true;
				$history->save();

				$invoice = $this->saleOrder->invoice();
				if($invoice['status'] != "Paid"){
					$invoice->paid();
				}

            	// $f_model = $this->add('xavoc\mlm\Model_Franchises');
	            // $f_model->loadLoggedIn();
	            $f_model->paymentReceived($invoice,$f_model->id);
				$this->app->db->commit();

			}catch(Exception $e){
				$this->app->db->rollback();
				throw $e;
			}

			$f->js(null,[
					$f->js()->closest('.dialog')->dialog('close'),
					$f->js()->_selector('.franchises-order-verification')->trigger('reload'),
				])->univ()->successMessage("Order Payment Received")
			->execute();
		}

	}
};