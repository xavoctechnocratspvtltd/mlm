<?php

namespace xavoc\mlm;

class Tool_FranchisesOrder extends \xepan\cms\View_Tool{
	public $options = [];

	function init(){
		parent::init();
		
		if($this->owner instanceof \AbstractController) return;

		$this->addClass('main-box');
		$this->app->stickyGET('distributor_id');
		$this->app->stickyGET('r_dist_id');

		$tab = $this->add('Tabs');
		$topup_tab = $tab->addTab('Topup/Re-Topup');
		$repurchase_tab = $tab->addTab('Repurchase');

		// $item = $this->add('xepan\commerce\Model_Item');
		$item = $this->add('xavoc\mlm\Model_Kit');
		$item->getElement('pv')->destroy();
		$item->getElement('bv')->destroy();
		$item->getElement('sv')->destroy();
		$item->getElement('introducer_income')->destroy();
		$item->getElement('dp')->destroy();

		$item->addExpression('capping_int')->set(function($m,$q){
			return $q->expr('CAST([0] AS SIGNED)',[$m->getElement('capping')]);
		});

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

		$dist = $this->add('xavoc\mlm\Model_Distributor');
		$dist->title_field = 'user';

		$form = $topup_tab->add('Form');
		$dist_field = $form->addField('autocomplete/Basic','distributor')->validate('required');
		$dist_field->setModel($dist);
		
		$kit_field = $form->addField('autocomplete/Basic','kit')->validate('required');
		$kit_field->setModel($item);

		$form->addField('text','payment_narration')->validate('required');

		// autocomplete reload
		$kit_field->send_other_fields = [$dist_field];
		

		// autocomplete reload
		if($dist_id = $_GET['o_'.$dist_field->name]){
			$last_kit = $this->add('xavoc\mlm\Model_TopupHistory')
				->addCondition('distributor_id',$dist_id)
				->setOrder('id','desc')
				->tryLoadAny();
			$last_capping = 0;
			if($last_kit->loaded())
				$last_capping = $last_kit['capping'];

			$kit_field->getModel()->addCondition('capping_int','>',$last_capping);
		}

		$form->addSubmit('Topup Now')->addClass('btn btn-primary');
		
		if($form->isSubmitted()){

			try{

				$this->app->db->beginTransaction();

				$distributor = $this->add('xavoc\mlm\Model_Distributor')->load($form['distributor']);

				$result = $distributor->placeTopupOrder($form['kit']);
				$order_id = $result['master_detail']['id'];
				
				$payment_detail['payment_narration'] = $form['payment_narration'];
				$payment_detail['is_payment_verified'] = true;

				$distributor->purchaseKit($form['kit']);
				$distributor->updateTopupHistory($form['kit'],$order_id,"deposite_in_franchies",$payment_detail);
				
				$order_model = $this->add('xepan\commerce\Model_SalesOrder');
				$order_model->load($order_id);
				$order_model->invoice()->paid();
				
				$this->app->db->commit();
			}catch(Exception $e){
				$this->app->db->rollback();
				throw $e;
			}

			$form->js(null,$form->js()->reload())->univ()->successMessage('distributor topuped successfully')->execute();
		}


		// repurchase
		$repurchase_tab->add('xavoc\mlm\View_FranchisesRepurchase');


	}
}