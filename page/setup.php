<?php

namespace xavoc\mlm;

class page_setup extends \Page {
	function init(){
		parent::init();

		// truncate 
		// contact, employee, customer, distributor, kit item, specification etc tables
		// add new default employee
		
		// add default specifications
		// create a few kits with different SV BV Capping and Introduction Income
			// to create kit first create an array and then create kit in foreach so we can add other kits easily

		$this->setupCompany();
	}

	function setupCompany(){

		// $this->app->auth->logout();

		// $this->app->auth->login($this->add('xepan\base\Model_User_Active')->tryLoadBy('username','management@xavoc.com'));

		// remove all ids
		$this->add('xavoc\mlm\Model_Distributor')
		->addCondition('type','Customer')
		->each(function($m){
			$m->delete();
		});

		// Add first id
		$user = $this->add('xepan\base\Model_User');

		$this->add('BasicAuth')
				->usePasswordEncryption('md5')
				->addEncryptionHook($user);
		
		$user->addCondition('username','admin@company.com');
		$user->tryLoadAny();
		$user['password']='admin';
		$user->save();

		$this->addCondition('path',0);
		$this->tryLoadAny();
		$this['first_name']="Company";
		$this['user_id']=$user->id;
		$this->save();
	}
}