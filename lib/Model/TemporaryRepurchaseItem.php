<?php

namespace xavoc\mlm;

class Model_TemporaryRepurchaseItem extends \xepan\base\Model_Table {
	public $table = "mlm_temporary_repurchase_item";

	function init(){
		parent::init();

			
		$this->hasOne('xavoc\mlm\Model_Distributor','distributor_id');
		$this->hasOne('xepan\commerce\Model_Item','item_id')->display(['form'=>'autocomplete/Basic']);

		$this->addExpression('image')->set($this->refSQL('item_id')->fieldQuery('first_image'));

		$this->addField('quantity');
		$this->addField('price')->defaultValue(0);

		$this->addExpression('amount')->set('quantity*price');

		$this->is([
				'distributor_id|required',
				'item_id|required',
				'quantity|required|int|gt|0',
				'price|int'
			]);

		$this->add('dynamic_model/Controller_AutoCreator');

		$this->addHook('beforeSave',$this);
	}

	function beforeSave(){
		if(!$this['price']){
			$kit = $this->add('xavoc\mlm\Model_Item')->load($this['item_id']);
			$this['price'] = $kit['dp'];
		}
	}


}