<?php

namespace xavoc\mlm;

class Model_GenerationIncomeSlab extends \xepan\base\Model_Table {
	
	public $table ='mlm_generation_income_slab';
	public $acl_type = "GenerationIncomeSlab";

	function init(){
		parent::init();

		$this->hasOne('xavoc\mlm\RePurchaseBonusSlab','rank_id');
		$this->addExpression('name')->set($this->refSQL('rank_id')->fieldQuery('name'));
		
		$this->addField('generation_1')->type('int');
		$this->addField('generation_2')->type('int');
		$this->addField('generation_3')->type('int');
		$this->addField('generation_4')->type('int');
		$this->addField('generation_5')->type('int');
		$this->addField('generation_6')->type('int');
		$this->addField('generation_7')->type('int');

		$this->setOrder('rank_id','asc');
		
	}
}