<?php

namespace xavoc\mlm;

class View_VerifyTopupPayment extends \View{

	public $orderid = null;
	public $distributor_id = null;

	function init(){
		parent::init();

		// if(!$this->orderid) throw new \Exception("order not found");
		if(!$this->distributor_id) throw new \Exception("distributor not found");
		
		$distributor = $this->add('xavoc\mlm\Model_Distributor')->load($this->distributor_id);

		$order_model = $this->add('xavoc\mlm\Model_SalesOrder');
		if($this->orderid)
			$order_model->load($this->orderid);


		$item = $this->add('xavoc\mlm\Model_Kit');
		$item->addExpression('capping_int')->set(function($m,$q){
			return $q->expr('CAST([0] AS SIGNED)',[$m->getElement('capping')]);
		});
		$item->addCondition('status','Published');
		
		$last_kit = $this->add('xavoc\mlm\Model_TopupHistory')
						->addCondition('distributor_id',$distributor->id)
						->setOrder('id','desc')
						->tryLoadAny()
						;

		// $item = $this->add('xepan\commerce\Model_Item');
		$item->title_field = "kit_with_price";
		$item->addExpression('kit_with_price')->set(function($m,$q){
			return $q->expr('CONCAT([0]," :: ",[1]," ::",[2])',
									[
										$m->getElement('name'),
										$m->getElement('sku'),
										$m->getElement('sale_price')
									]
				);
		});
		$item->addCondition('is_package',true);
		if($last_kit->loaded())
			$item->addCondition('capping_int','>',$last_kit['capping']);

		$form = $this->add('Form');
		
		if($order_model->loaded() && $order_model->details()->count()->getOne() == 1 && $order_model['is_topup_included']){
			$topup_oi = $order_model->details()->tryLoadAny();
			$item->load($topup_oi['item_id']);
			$form->add("View")->set($item['kit_with_price'])->addClass('alert alert-info');
			$form->addField('hidden','kit')->set($item->id);
		}else{

			// $item->addExpression('capping_int')->set(function($m,$q){
			// 	return $q->expr('CAST([0] AS SIGNED)',[$m->getElement('capping')]);
			// });
			// $item->addCondition('status','Published');

			// if($distributor['kit_item_id']){
			// 	$last_kit = $this->add('xavoc\mlm\Model_TopupHistory')
			// 				->addCondition('distributor_id',$distributor->id)
			// 				->setOrder('id','desc')
			// 				->tryLoadAny()
			// 				;
			// 	if($last_kit->loaded())
			// 		$item->addCondition('capping_int','>',$last_kit['capping']);
			// }
			$form->addField('DropDown','kit')->validate('required')->setModel($item);
		}
		
		$topup_history = $this->add('xavoc\mlm\Model_TopupHistory');
		$topup_history->addCondition('distributor_id',$distributor->id);
		
		if($order_model->loaded()){
			$topup_history->addCondition('sale_order_id',$order_model->id);
			$topup_history->tryLoadAny();
		}
		

		$payment_mode_field = $form->addField('DropDown','payment_mode')
					->setValueList(['online'=>'Online','cheque'=>'Cheque','dd'=>'DD','deposite_in_franchies'=>'Deposite in Franchises','deposite_in_company'=>'Deposite in company'])
					->set($topup_history['payment_mode']);

		$form->setModel($topup_history,[
								'online_transaction_reference',
								'online_transaction_detail',
								'bank_name',
								'bank_ifsc_code',
								'cheque_number',
								'dd_number',
								'cheque_date',
								'dd_date',
								'deposite_date',
								'payment_narration',
								'cheque_deposite_receipt_image_id',
								'dd_deposite_receipt_image_id',
								'office_receipt_image_id'
						]);

		$mandatory_field_set = [
					'online'=>['online_transaction_detail','online_transaction_reference'],
					'cheque'=>['bank_name','bank_ifsc_code','cheque_number','cheque_date','deposite_date','cheque_deposite_receipt_image_id'],
					'dd'=>['bank_name','bank_ifsc_code','dd_number','dd_date','deposite_date','dd_deposite_receipt_image_id'],
					'deposite_in_company'=>['payment_narration','office_receipt_image_id'],
					'deposite_in_franchies'=>['payment_narration','office_receipt_image_id']
				];

		$payment_mode_field->js(true)->univ()->bindConditionalShow($mandatory_field_set,'div.atk-form-row');

		$form->addSubmit('Verify Payment')->addClass('btn btn-primary');
		if($form->isSubmitted()){
			
			// validation check info
			if($order_model->loaded()){
				$required_field = $mandatory_field_set[$form['payment_mode']];
				foreach ($required_field as $key => $field_name) {
					if(!$form[$field_name] && $field_name != 'payment_narration'){
						$form->error($field_name,'must not be empty');
						break;
					}
				}
			}
			
			try{
				$this->app->db->beginTransaction();
				
				$distributor['is_payment_verified'] = true;

				$distributor->save();
				if($order_model->loaded()){
					$order_model->invoice()->paid();
					$form->model['sale_order_id'] = $order_model->id;
					$form->model['is_payment_verified'] = true;
					$form->update();
				}
				else{
					// create order on dehalf of kit
					$result = $distributor->placeTopupOrder($form['kit']);
					$order_id = $result['master_detail']['id'];
					
					$payment_detail = $form->get();					
					$payment_detail['is_payment_verified'] = true;
					$distributor->purchaseKit($form['kit']);
					$distributor->updateTopupHistory($form['kit'],$order_id,$form['payment_mode'],$payment_detail);
					
					$order_model = $this->add('xepan\commerce\Model_SalesOrder');
					$order_model->load($result['master_detail']['id']);
					$order_model->invoice()->paid();
				}
				
				// update topup attachment

				$this->app->db->commit();
			}catch(\Exception $e){
				
				$this->app->db->rollback();

				$form->js(null,$form->js()->closest('.dialog')->dialog('close'))->univ()->errorMessage($e->getMessage()." , something wrong")->execute();
			}
			
			$js_event = [
					$form->js()->redirect('xavoc_dm_distributors')
					// $form->js()->_selector('.dialog')->dialog('close')
					// $(".ui-dialog-content").dialog("close");
				];		
			$form->js(null,$js_event)->univ()->successMessage('payment verified and marked green')->execute();
		}

	}
}