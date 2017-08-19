<?php

namespace xavoc\mlm;

class View_FranchisesRepurchase extends \View{


	function init(){
		parent::init();

		$this->franchises = $franchises = $this->add('xavoc\mlm\Model_Franchises');
		$franchises->loadLoggedIn();

		$dist_id = $this->app->stickyGET('r_dist_id');

		$dist = $this->add('xavoc\mlm\Model_Distributor');
		$dist->title_field = 'user';
	

		$form = $this->add('Form');
		$dist_field = $form->addField('autocomplete/Basic','distributor')->validate('required');
		$dist_field->setModel($dist);
		$form->addSubmit('Go')->addClass('btn btn-primary ds-button');

		// $grid = $this->add('Grid');
		// $dist = $this->add('xavoc\mlm\Model_Distributor');
		// $dist->addExpression('distributor_username')->set($dist->refSQL('user_id')->fieldQuery('username'));
		
		// $grid->setModel($dist,['name']);

		$model = $this->add('xavoc\mlm\Model_TemporaryRepurchaseItem');
		if($dist_id)
			$model->addCondition('distributor_id',$dist_id);
		else
			$model->addCondition('distributor_id',-1);

		$view = $this->add('View');
		if($dist_id){
			$crud = $view->add('CRUD',['entity_name'=>'Repurchase Product']);
			$crud->setModel($model,['item_id','quantity'],['item','quantity','price','tax_percentage','tax_amount','amount']);
			$crud->grid->addTotals(['amount']);

			$submit_form = $view->add('Form');
			$submit_form->addField('text','payment_narration');
			$submit_form->addSubmit('Place Repurchase Order and Receive Payment')->addClass('btn btn-primary');

			if($submit_form->isSubmitted()){
				$temp_oi = $this->add('xavoc\mlm\Model_TemporaryRepurchaseItem');
				$temp_oi->addCondition('distributor_id',$dist_id);
				if(!$temp_oi->count()->getOne()){
					$submit_form->js()->univ()->errorMessage('first add repurchase product ...')->execute();
				}

				$distributor = $this->add('xavoc\mlm\Model_Distributor')->load($dist_id);

				try{
					$this->app->db->beginTransaction();
					
					$result = $distributor->placeRepurchaseOrder($this->franchises->id);
					if(!isset($result['master_detail']['id']) OR !$result['master_detail']['id']) throw new \Exception("order not created");
						
					// delete temporary repurchase items
					$temp_oi = $this->add('xavoc\mlm\Model_TemporaryRepurchaseItem');
					$temp_oi->addCondition('distributor_id',$distributor->id);
					$temp_oi->deleteAll();

					$order_id = $result['master_detail']['id'];
					$order_model = $this->add('xavoc\mlm\Model_SalesOrder');
					$order_model->load($order_id);
					$order_model->invoice()->paid();
						
					// update repurchase history
					$rh = $this->add('xavoc\mlm\Model_RepurchaseHistory');
					$rh['distributor_id'] = $distributor->id;
					$rh['sale_order_id'] = $order_id;
					$rh['payment_narration'] = $submit_form['payment_narration'];
					$rh['payment_mode'] = 'deposite_in_franchies';
					$rh['is_payment_verified'] = true;
					$rh->save();

					$this->app->db->commit();
				}catch(\Exception $e){
					$this->app->db->rollback();
					throw $e;
				}
				
				$this->app->stickyForget('r_dist_id');
				$submit_form->js(null,[$view->js()->reload()])->univ()->successMessage('re-purchase order created and payment received')->execute();

			}
		}

		if($form->isSubmitted()){
			$form->js(null,$view->js()->reload(['r_dist_id'=>$form['distributor']]))->execute();
		}

	}
}