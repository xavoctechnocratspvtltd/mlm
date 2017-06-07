<?php

namespace xavoc\mlm;


class Model_Closing extends \xepan\base\Model_Table {
	public $table = "mlm_closing";

	function init(){
		parent::init();
	}

	function doClosing($on_date=null){
		if(!$on_date) $on_date = $this->app->now;
	}
}