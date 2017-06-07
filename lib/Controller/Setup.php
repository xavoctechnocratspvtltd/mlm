<?php

namespace xavoc\mlm;

class Controller_Setup extends \AbstractController {
	function init(){
		parent::init();

		// truncate 
		// contact, employee, customer, distributor, kit item, specification etc tables
		// add new default employee
		
		// add default specifications

		$specfic_array=['BV','SV','PV','Capping','Introduction Income'];
		foreach ($specfic_array as $sp) {
			$this->add('xepan\commerce\Model_Item_Specification')
					->addCondition('name',$sp)
					->tryLoadAny()
					->save();
		}

		$item_array=[
					['name'=>'kit 1','code'=> 'kit1','pv'=>'1','bv'=>'1','sv'=>'1','capping'=>'1','introducer_income'=>'1'],
					['name'=>'kit 2','code'=> 'kit2','pv'=>'1','bv'=>'1','sv'=>'1','capping'=>'1','introducer_income'=>'1'],
					['name'=>'kit 3','code'=> 'kit3','pv'=>'1','bv'=>'1','sv'=>'1','capping'=>'1','introducer_income'=>'1'],
					['name'=>'kit 4','code'=> 'kit4','pv'=>'1','bv'=>'1','sv'=>'1','capping'=>'1','introducer_income'=>'1'],
					['name'=>'kit 5','code'=> 'kit5','pv'=>'1','bv'=>'1','sv'=>'1','capping'=>'1','introducer_income'=>'1']
		];
		foreach ($item_array as $item) {
			$kit = $this->add('xavoc\mlm\Model_Kit')
					->addCondition('sku',$item['code'])
					->tryLoadAny();
			$kit->set('name',$item['name'])
				->set('pv',$item['pv'])
				->set('bv',$item['bv'])
				->set('sv',$item['sv'])
				->set('capping',$item['capping'])
				->set('introducer_income',$item['introducer_income'])
				->save();
		}


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

		$dis = $this->add('xavoc\mlm\Model_Distributor');
		$dis->addCondition('path',0);
		$dis->tryLoadAny();
		$dis['first_name']="Company";
		$dis['user_id']=$user->id;
		$dis->save();

	}
}