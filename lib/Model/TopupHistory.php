<?php

namespace xavoc\mlm;


class Model_TopupHistory extends \xepan\base\Model_Table {
	public $table = "mlm_topup_history";
	// public $acl_type= "ispmanager_distributor";

	function init(){
		parent::init();

		$this->hasOne('xavoc\mlm\Model_Distributor','distributor_id');
		$this->hasOne('xavoc\mlm\Model_Kit','kit_item_id');
		$this->addField('bv');
		$this->addField('pv');
		$this->addField('sv');
		$this->addField('capping');
		$this->addField('introduction_income');
		$this->addField('sale_price');
		$this->addField('sale_order_id');
		
		$this->add('xepan\filestore\Field_Image','cheque_deposite_receipt_image_id');//->caption('Upload Your Aadhar Card');
		$this->add('xepan\filestore\Field_Image','dd_deposite_receipt_image_id');//->caption('Upload Your Aadhar Card');
		$this->add('xepan\filestore\Field_Image','office_receipt_image_id');//->caption('Upload Your Aadhar Card');
		$this->addField('payment_narration')->type('text');
		$this->addField('created_at')->type('datetime')->defaultValue($this->app->now);

		$this->addField('online_transaction_reference');
		$this->addField('online_transaction_detail')->type('text');
		$this->addField('bank_name');
		$this->addField('bank_ifsc_code');
		$this->addField('cheque_number');
		$this->addField('dd_number');
		$this->addField('deposite_date')->type('date');
		$this->addField('cheque_date')->type('date');
		$this->addField('dd_date')->type('date');
		$this->addField('is_payment_verified')->type('boolean');

		$this->addField('payment_mode')->enum(['online','cash','cheque','dd','deposite_in_franchies','deposite_in_company']);
		// $this->addField('payment_mode');

		$this->add('dynamic_model/Controller_AutoCreator');
	}
}