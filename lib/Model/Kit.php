<?php

namespace xavoc\mlm;


class Model_Kit extends \xepan\base\Model_Tabel {
	public $table = "mlm_kit";

	function init(){
		parent::init();

		$this->addField('name');
		$this->addField('pv')->type('int');
		$this->addField('bv')->type('int');
		$this->addField('sv')->type('int');
		$this->addField('capping')->type('int');
		$this->addField('introducer_income')->type('int');

		$this->hasMany('xavoc\mlm\KitItem','mlm_kit_id');

	}
}