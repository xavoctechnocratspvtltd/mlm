<?php

namespace xavoc\mlm;

class Model_RepurchaseHistory extends \xepan\base\Model_Table {
	public $table = "mlm_repurchase_order_history";
	// public $acl_type= "ispmanager_distributor";

	function init(){
		parent::init();

		$this->hasOne('xavoc\mlm\Model_Distributor','distributor_id');
		$this->hasOne('xavoc\mlm\Model_SalesOrder','sale_order_id');
		$this->hasOne('xavoc\mlm\Model_Customer','related_customer_id');
		
		// $this->addField('total_bv');
		// $this->addField('total_pv');
		// $this->addField('total_sv');
		// $this->addField('total_capping');
		// $this->addField('total_introduction_income');
		
		$this->add('xepan\filestore\Field_Image','cheque_deposite_receipt_image_id');
		$this->add('xepan\filestore\Field_Image','dd_deposite_receipt_image_id');
		$this->add('xepan\filestore\Field_Image','office_receipt_image_id');
		
		$this->addField('payment_narration')->type('text');

		$this->addField('created_at')->type('datetime')->defaultValue($this->app->now);
		$this->addField('online_transaction_reference');
		$this->addField('online_transaction_detail')->type('text');
		$this->addField('bank_name');
		$this->addField('bank_ifsc_code');

		$this->addField('cheque_number');
		$this->addField('cheque_date')->type('date');

		$this->addField('dd_number');
		$this->addField('dd_date')->type('date');

		$this->addField('deposite_date')->type('date');
		$this->addField('is_payment_verified')->type('boolean');

		$this->addField('payment_mode')->enum(['online','cheque','dd','deposite_in_franchies','deposite_in_company']);

		$this->add('dynamic_model/Controller_AutoCreator');
		$this->is([
			'payment_mode|required'
			]);
	}
}