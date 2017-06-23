<?php

namespace xavoc\mlm;

class Model_SalesOrder extends \xepan\commerce\Model_SalesOrder {
	public $table_alias =  'mlm_sale_order';
	
	function verifyRepurchasePayment(){
		if(!$this->loaded()) $this->throw('sale ordre model not loaded')->addMoreInfo('in mlm sale order');
		// mark order invoice and paid invoice
		// distribute repurchase value
		// mark order complete and dispatch the goods
		$sale_invoice = $this->invoice();
		$sale_invoice->paid();
		$this->complete();
	}
} 