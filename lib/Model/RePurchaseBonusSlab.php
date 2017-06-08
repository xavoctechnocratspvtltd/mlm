<?php

namespace xavoc\mlm;

class Model_RePurchaseBonus extends \xepan\base\Model_Table {
	public $table ='mlm_re_purchase_bonus_slab';

	function init(){
		parent::init();

		$this->addField('name');
		$this->addField('slab_percentage')->type('int');
		$this->addField('from_bv')->type('int');
		$this->addField('to_bv')->type('int');

		$this->setOrder('to_bv','desc');

	}
}