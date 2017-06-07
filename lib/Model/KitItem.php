<?php

namespace xavoc\mlm;


class Model_KitItem extends \xepan\base\Model_Table {
	public $table = "mlm_kit_item_asso";

	function init(){
		parent::init();
		$this->hasOne('xavoc\mlm\Kit','mlm_kit_id');
		$this->hasOne('xavoc\mlm\Item','mlm_item_id');
	}
}