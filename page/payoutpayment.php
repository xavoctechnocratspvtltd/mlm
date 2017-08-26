<?php


namespace xavoc\mlm;

class page_payoutpayment extends \xepan\base\Page {
	public $title= "Payout Payment";

	function init(){
		parent::init();

		$closing_id = $this->app->stickyGET('closing_id');

		$closing = $this->add('xavoc\mlm\Model_Closing');
		$closing->load($closing_id);

		if($closing['type'] == 'DailyClosing'){
			$this->add('View')->addClass('alert alert-danger')->set('No Payout for Daily closing');
			return;
		}

		// $field_to_show = [];
		// if($closing['type'] == "WeeklyClosing"){
		$field_to_show = ['distributor','user','closing_date','previous_carried_amount','leadership_carried_amount','binary_income','introduction_amount','gross_payment','tds','admin_charge','net_payment','carried_amount','paid_on','paid_amount'];
		// }

		$m = $this->add('xavoc\mlm\Model_Payout');
		$m->getElement('net_payment')->sortable(true);
		$m->getElement('distributor_id')->sortable(true);

		$m->addExpression('user')->set(function($m,$q){
			return $m->refSQL('distributor_id')->fieldQuery('user');
		});

		// $m->addExpression('account_number')->set(function($m,$q){
		// 	return $m->refSQL('distributor_id')->fieldQuery('d_account_number');
		// });

		// $m->addExpression('bank_name')->set(function($m,$q){
		// 	return $m->refSQL('distributor_id')->fieldQuery('d_bank_name');
		// });

		// $m->addExpression('bank_ifsc_code')->set(function($m,$q){
		// 	return $m->refSQL('distributor_id')->fieldQuery('d_bank_ifsc_code');
		// });

		// $m->addExpression('mobile_number')->set(function($m,$q){
		// 	return $m->refSQL('distributor_id')->fieldQuery('mobile_number');
		// });

		// $m->addExpression('email')->set(function($m,$q){
		// 	return $m->refSQL('distributor_id')->fieldQuery('email');
		// });

		// $m->addExpression('address')->set(function($m,$q){
		// 	return $q->expr('CONCAT([0],", ",[1],", ",[2],", ",[3])',[
		// 			$m->refSQL('distributor_id')->fieldQuery('address'),
		// 			$m->refSQL('distributor_id')->fieldQuery('city'),
		// 			$m->refSQL('distributor_id')->fieldQuery('state'),
		// 			$m->refSQL('distributor_id')->fieldQuery('country'),
		// 		]);
		// });

		$m->addCondition('closing_id',$closing_id);
		$m->addCondition('net_payment','>',0);

		$form = $this->add('Form');
		$form->addField('DatePicker','payment_date');
		$form->addSubmit('Pay Now');

		$crud = $this->add('CRUD',['allow_add'=>false,'allow_del'=>false]);
		$g = $crud->grid;

		if($form->isSubmitted()){
			if(!$form['payment_date']) $form->error('payment_date','must not be empty');
			
			if(strtotime($form['payment_date']) < strtotime($closing['on_date'])) $form->error('payment_date','must equal or greater then closing date');
			
			foreach ($m as $pm) {
				$pm['paid_on'] = $form['payment_date'];
				$pm['paid_amount'] = $pm['net_payment'];
				$pm->save();
			}
			
			$form->js(null,$crud->js()->reload())->univ()->successMessage('Payment Paid sucessfully')->execute();
		}

		// if(count($field_to_show) > 0)
		// 	$crud->setModel($m,['paid_on','paid_amount'],$field_to_show);
		// else
			$crud->setModel($m,['paid_on','paid_amount'],$field_to_show);

		$g->addOrder()->move('user','after','distributor')->now();
		$g->removeColumn('closing');
		$g->addPaginator($ipp=100);
		$g->addQuickSearch(['user','distributor']);
		// $g->add("misc/Export");
	}
}