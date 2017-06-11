<?php

namespace xavoc\mlm;

class Mdoel_Closing extends \xepan\base\Model_Document {
	
	function init(){
		parent::init();

		$cls_j = $this->join('mlm_closing.closing_id');
		$cls_j->addField('on_date')->type('datetime');
		$this->hasMany('xavoc\mlm\Payout','closing_id');

	}
}