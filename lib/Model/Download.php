<?php

namespace xavoc\mlm;


class Model_Download extends \xepan\base\Model_Table {
	public $table = "mlm_download";

	function init(){
		parent::init();

		$this->addField('name');
		$this->addField('description')->display(['form'=>'xepan\base\RichText'])->type('text');

		$this->addField('status')->enum(['Active','InActive'])->defaultValue('Active');
		$this->addField('type');
		$this->addCondition('type','Download');
		
		$this->add('xepan\filestore\Field_File','image_id');

		$this->add('dynamic_model/Controller_AutoCreator');
	}
}