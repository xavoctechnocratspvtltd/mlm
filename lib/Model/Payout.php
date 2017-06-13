<?php

namespace xavoc\mlm;


class Model_Payout extends \xepan\base\Model_Table {
	public $table = "mlm_payout";

	function init(){
		parent::init();

		$this->hasOne('xavoc\mlm\Closing','closing_id');
		$this->hasOne('xavoc\mlm\Distributor','distributor_id');
		$this->addField('closing_date')->type('datetime');
		$this->addField('previous_carried_amount');
		$this->addField('binary_income')->type('money');
		$this->addField('introduction_amount')->type('money');
		$this->addField('retail_profit')->type('money');
		
		$this->addField('rank');
		$this->addField('slab_percentage')->type('number');

		$this->addField('generation_month_business')->type('int');
		$this->addField('generation_total_business')->type('int');
		$this->addField('capped_total_business')->type('int');
		$this->addField('re_purchase_income_gross')->type('int');

		$this->addField('repurchase_bonus')->type('money');
		
		$this->addField('generation_income_1')->type('money');
		$this->addField('generation_income_2')->type('money');
		$this->addField('generation_income_3')->type('money');
		$this->addField('generation_income_4')->type('money');
		$this->addField('generation_income_5')->type('money');
		$this->addField('generation_income_6')->type('money');
		$this->addField('generation_income_7')->type('money');

		$this->addField('generation_income')->type('money');
		$this->addField('loyalty_bonus')->type('money');
		$this->addField('leadership_bonus')->type('money');
		$this->addField('gross_payment')->type('money');
		$this->addField('tds')->type('money');
		$this->addField('admin_charge')->type('money');
		$this->addField('net_payment')->type('money');
		$this->addField('carried_amount')->type('money');

	}

	
}