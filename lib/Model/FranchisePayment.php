<?php

namespace xavoc\mlm;


class Model_FranchisePayment extends \xepan\base\Model_Table {
	public $table = "mlm_franchise_payment";

	function init(){
		parent::init();

		// $this->hasOne('xavoc\mlm\Model_Distributor','distributor_id');
		$this->hasOne('xavoc\mlm\Model_SalesInvoice','sale_invoice_id');
		$this->hasOne('xavoc\mlm\Model_Franchises','franchise_id');

		$this->addField('net_amount')->type('Number')->defaultValue(0);

		$this->add('dynamic_model/Controller_AutoCreator');
	}
}