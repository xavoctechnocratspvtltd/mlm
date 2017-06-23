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
		$distributor = $this->add('xavoc\mlm\Model_Distributor');
		$distributor->load($this['contact_id']);
		//invoice paid hook is not working so temporary hard code for update ancesesters
		foreach ($this->orderItems() as $oi) {
			$item = $this->add('xavoc\mlm\Model_Item')->load($oi['item_id']);
			if($item['is_package']){
				// if kit then update SV
				$distributor->updateAnsestorsSV($item['sv']);
			}else{
				// update bv
				$distributor->repurchase($item['bv']);
			}
		}

		$this->complete();
	}
} 