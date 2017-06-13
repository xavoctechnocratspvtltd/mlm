<?php

namespace xavoc\mlm;

class Model_RePurchaseBonusSlab extends \xepan\base\Model_Table {
	
	public $table ='mlm_re_purchase_bonus_slab';
	public $acl_type = "RePurchaseBonusSlab";
	
	function init(){
		parent::init();

		$this->addField('name');
		$this->addField('slab_percentage')->type('int');
		$this->addField('from_bv')->type('int');
		$this->addField('to_bv')->type('int');
		$this->addField('required_60_percentage')->type('boolean')->defaultValue(true);

		$this->setOrder('slab_percentage','asc');

	}
}