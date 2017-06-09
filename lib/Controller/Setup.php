<?php

namespace xavoc\mlm;

class Controller_Setup extends \AbstractController {
	function init(){
		parent::init();

		// truncate 
		// contact, employee, customer, distributor, kit item, specification etc tables
		// add new default employee
		

		$this->add('xavoc\mlm\Model_Distributor')->each(function($m){
			$m->delete();
		});
		
		$item =$this->add('xepan\commerce\Model_Item')->each(function($m){
			$m->delete();
		});
		$this->add('xepan\commerce\Model_Item_Specification')->each(function($m){
			$m->delete();
		});

		// add default specifications
		$specfic_array=['BV','SV','PV','Capping','Introduction Income'];
		foreach ($specfic_array as $sp) {
			$this->add('xepan\commerce\Model_Item_Specification')
					->addCondition('name',$sp)
					->tryLoadAny()
					->save();
		}

		$item_array=[
					['name'=>'Package 1','code'=> 'package1','pv'=>'0','bv'=>'200','sv'=>'1000','capping'=>'5000','introducer_income'=>'50'],
					['name'=>'Package 2','code'=> 'package2','pv'=>'0','bv'=>'700','sv'=>'3000','capping'=>'10000','introducer_income'=>'150'],
					['name'=>'Package 3','code'=> 'package3','pv'=>'0','bv'=>'1500','sv'=>'6000','capping'=>'15000','introducer_income'=>'300'],
					['name'=>'Package 4','code'=> 'package4','pv'=>'0','bv'=>'3200','sv'=>'12000','capping'=>'25000','introducer_income'=>'600']
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

		$re_purchase_slab = [
			['name'=>'Star',		'slab_percentage'=>5,	'from_bv'=>199, 	'to_bv'=>3000],
			['name'=>'Yellow Star',	'slab_percentage'=>10,	'from_bv'=>3001, 	'to_bv'=>10000],
			['name'=>'Orange Star',	'slab_percentage'=>15,	'from_bv'=>10001, 	'to_bv'=>35000],
			['name'=>'Red Star',	'slab_percentage'=>20,	'from_bv'=>35001, 	'to_bv'=>100000],
			['name'=>'Purpule Star','slab_percentage'=>25,	'from_bv'=>100001, 	'to_bv'=>250000],
			['name'=>'Green Star',	'slab_percentage'=>30,	'from_bv'=>250001, 	'to_bv'=>500000],
			['name'=>'Brown Star',	'slab_percentage'=>35,	'from_bv'=>500001, 	'to_bv'=>2500000],
			['name'=>'Blue Star',	'slab_percentage'=>40,	'from_bv'=>2500001, 'to_bv'=>5000000],
		];

		foreach ($re_purchase_slab as $row) {
			$slab = $this->add('xavoc\mlm\Model_RePurchaseBonusSlab')
						->addCondition('name',$row['name'])
						->tryLoadAny();
			$slab['slab_percentage']=$row['slab_percentage'];
			$slab['from_bv']=$row['from_bv'];
			$slab['to_bv']=$row['to_bv'];
			$slab->save();
		}

		$generation_income_slab = [
			['name'=>'Yellow Star',	'generation_1'=>10,'generation_2'=>00,'generation_3'=>00,'generation_4'=>0,'generation_5'=>0,'generation_6'=>0,'generation_7'=>0],
			['name'=>'Orange Star',	'generation_1'=>10,'generation_2'=>10,'generation_3'=>00,'generation_4'=>0,'generation_5'=>0,'generation_6'=>0,'generation_7'=>0],
			['name'=>'Red Star',	'generation_1'=>10,'generation_2'=>10,'generation_3'=>10,'generation_4'=>0,'generation_5'=>0,'generation_6'=>0,'generation_7'=>0],
			['name'=>'Purpule Star','generation_1'=>10,'generation_2'=>10,'generation_3'=>10,'generation_4'=>5,'generation_5'=>0,'generation_6'=>0,'generation_7'=>0],
			['name'=>'Green Star',	'generation_1'=>10,'generation_2'=>10,'generation_3'=>10,'generation_4'=>5,'generation_5'=>5,'generation_6'=>0,'generation_7'=>0],
			['name'=>'Brown Star',	'generation_1'=>10,'generation_2'=>10,'generation_3'=>10,'generation_4'=>5,'generation_5'=>5,'generation_6'=>5,'generation_7'=>0],
			['name'=>'Blue Star',	'generation_1'=>10,'generation_2'=>10,'generation_3'=>10,'generation_4'=>5,'generation_5'=>5,'generation_6'=>5,'generation_7'=>5]
		];

		foreach ($generation_income_slab as $row) {
			$slab = $this->add('xavoc\mlm\Model_GenerationIncomeSlab')
						->addCondition('name',$row['name'])
						->tryLoadAny();
			foreach ($row as $field => $value) {
				$slab[$field]=$value;
			}

			$slab['rank_id'] = $this->add('xavoc\mlm\Model_RePurchaseBonusSlab')->loadBy('name',$row['name'])->get('id');
			$slab->save();
		}


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