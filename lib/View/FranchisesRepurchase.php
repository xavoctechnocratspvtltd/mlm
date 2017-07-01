<?php

namespace xavoc\mlm;

class View_FranchisesRepurchase extends \View{


	function init(){
		parent::init();

		$dist_id = $this->app->stickyGET('r_dist_id');

		$form = $this->add('Form');
		$form->addField('distributor_id');
		$form->addSubmit('Go');

		$grid = $this->add('Grid');
		$dist = $this->add('xavoc\mlm\Model_Distributor');
		$dist->addExpression('distributor_username')->set($dist->refSQL('user_id')->fieldQuery('username'));

		if($dist_id){
			$dist->addCondition('distributor_username',$dist_id);
		}
		else
			$dist->addCondition('id',-1);
		$grid->setModel($dist,['name']);

		if($form->isSubmitted()){
			$form->js(null,$grid->js()->reload(['r_dist_id'=>$form['distributor_id']]))->execute();
		}

		$grid->add('VirtualPage')
			->addColumn('Repurchase')
			->set(function($page){

				$id = $_GET[$page->short_name.'_id'];
				$distributor = $this->add('xavoc\mlm\Model_Distributor')->load($id);

				$model = $page->add('xavoc\mlm\Model_TemporaryRepurchaseItem');
				$model->addCondition('distributor_id',$id);
				$crud = $page->add('CRUD');
				$crud->setModel($model,['item_id','quantity'],['item','quantity','price','amount']);
				
				$form = $page->add('Form');
				$form->addField('text','payment_narration');
				$form->addSubmit('Place Repurchase Order and Receive Payment');

				if($form->isSubmitted()){

					$temp_oi = $this->add('xavoc\mlm\Model_TemporaryRepurchaseItem');
					$temp_oi->addCondition('distributor_id',$distributor->id);

					if(!$temp_oi->count()->getOne()){
						$form->js()->univ()->errorMessage('first add repurchase product ...')->execute();
					}


					try{
						$this->app->db->beginTransaction();
						
						$result = $distributor->placeRepurchaseOrder();
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
						$rh['distributor_id'] = $id;
						$rh['sale_order_id'] = $order_id;
						$rh['payment_narration'] = $form['payment_narration'];
						$rh['payment_mode'] = 'deposite_in_franchies';
						$rh['is_payment_verified'] = true;
						$rh->save();

						$this->app->db->commit();

					}catch(\Exception $e){
						$this->app->db->rollback();
						throw $e;
					}
					
					$form->js(null,$form->js()->closest('.dialog')->dialog('close'))->univ()->successMessage('re-purchase order created and payment received')->execute();
				}
				
			});

	}
}