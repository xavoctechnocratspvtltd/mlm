<?php

namespace xavoc\mlm;

class Model_LoyaltiBonusSlab extends \xepan\base\Model_Table {
	
	public $table ='mlm_loyalti_bonus_slab';
	public $acl_type = "LoyaltiBonusSlab";

	function init(){
		parent::init();

		$this->hasOne('xavoc\mlm\RePurchaseBonusSlab','rank_id');
		$this->addExpression('name')->set($this->refSQL('rank_id')->fieldQuery('name'));
		
		$this->addField('distribution_percentage')->type('int');
		$this->addField('turnover_criteria')->type('int');

		$this->setOrder('rank_id','asc');
		
	}
}