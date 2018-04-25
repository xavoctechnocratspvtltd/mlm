<?php

namespace xavoc\mlm;

class Model_TemporaryRepurchaseItem extends \xepan\base\Model_Table {
	public $table = "mlm_temporary_repurchase_item";

	function init(){
		parent::init();

			
		$this->hasOne('xavoc\mlm\Model_Distributor','distributor_id');
		$item_field = $this->hasOne('xavoc\mlm\Model_RepurchaseItem','item_id');
		$item_field->getModel()->addCondition('status','Published');
		$item_field->display(['form'=>'DropDown']);

		$this->addExpression('image')->set($this->refSQL('item_id')->fieldQuery('first_image'));

		$this->addField('quantity');
		$this->addField('price')->defaultValue(0);
		$this->addField('taxation_id');
		$this->addField('tax_percentage');
		$this->addField('tax_amount')->defaultValue(0)->type('money');

		$this->addExpression('amount')->set('(quantity*price)+tax_amount')->type('money');

		$this->is([
				'distributor_id|required',
				'item_id|required',
				'quantity|required|int|gt|0',
				'price|number'
			]);

		$this->add('dynamic_model/Controller_AutoCreator');

		$this->addHook('beforeSave',$this);
	}

	function beforeSave(){
		
			$kit = $this->add('xavoc\mlm\Model_Item')->load($this['item_id']);
			$this['price'] = $kit['dp'];
			$tax_array = $kit->getTaxAmount($this['distributor_id'],$this['quantity']);
			$this['taxation_id'] = $tax_array['taxation_id'];
			$this['tax_percentage'] = $tax_array['tax_percentage'];
			$this['tax_amount'] = $tax_array['tax_amount'];
	}


}