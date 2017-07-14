<?php

namespace xavoc\mlm;


class Model_AssignOrder extends \xepan\base\Model_Table {
	public $table = "mlm_assign_order";

	function init(){
		parent::init();

		$this->hasOne('xavoc\mlm\Model_Franchises','franchises_id');
		$this->hasOne('xavoc\mlm\Model_SalesOrder','saleorder_id');
		$this->hasOne('xepan\base\Model_User','created_by_id');
		$this->addField('created_at')->type('datetime')->defaultValue($this->app->now);
		// $this->addField('created_by_id');

		// status from order status
		$this->addExpression('status')->set($this->refSQL('saleorder_id')->fieldQuery('status'));

		$this->is([
					'franchises_id|to_trim|required',
					'saleorder_id|to_trim|required',
					'created_at|to_trim|required',
					'created_by_id|to_trim|required'
				]);

		$this->add('dynamic_model/Controller_AutoCreator');
	}
}