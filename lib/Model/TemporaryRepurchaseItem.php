<?php

namespace xavoc\mlm;

class Model_TemporaryRepurchaseItem extends \xepan\base\Model_Table {
	public $table = "mlm_temporary_repurchase_item";

	function init(){
		parent::init();

			
		$this->hasOne('xavoc\mlm\Model_Distributor','distributor_id');
		$this->hasOne('xepan\commerce\Model_Item','item_id');

		$this->addExpression('image')->set($this->refSQL('item_id')->fieldQuery('first_image'));

		$this->addField('quantity');
		$this->addField('price')->defaultValue(0);


		$this->add('dynamic_model/Controller_AutoCreator');
	}
}