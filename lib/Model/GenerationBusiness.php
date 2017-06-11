<?php

namespace xavoc\mlm;


class Model_GenerationBusiness extends \xepan\base\Model_Table{ 
	public $table = 'mlm_generation_business';

	function init(){
		parent::init();

		$this->hasOne('xavoc\mlm\Distributor','distributor_id');
		$this->hasOne('xavoc\mlm\Distributor','introduced_id');
		$this->addField('introduced_path')->type('text');
		$this->addField('bv_sum')->type('number')->defaultValue(0);
		$this->addField('month_bv')->type('number')->defaultValue(0);
		
	}
}