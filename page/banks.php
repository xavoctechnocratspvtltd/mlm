<?php


namespace xavoc\mlm;

class page_banks extends \xepan\base\Page {
	public $title= "Manage Banks";

	function init(){
		parent::init();

		$banks = $this->add('xepan\base\Model_ConfigJsonModel',
			[
				'fields'=>[
							'bank_name'=>'line'
							],
					'config_key'=>'DS_DEFAULT_BANKS_LIST',
					'application'=>'xavoc\mlm'
			]);
		
		$crud = $this->add('xepan\hr\CRUD');
		$crud->setModel($banks,['bank_name']);
	}

}