<?php

namespace xavoc\mlm;

class Controller_Setup extends \AbstractController {
	public $remove_everything = false;
	public $importing_old_data = false;
	function init(){
		parent::init();

		// truncate 
		// contact, employee, customer, distributor, kit item, specification etc tables
		// add new default employee
		

		$this->add('xavoc\mlm\Model_Distributor')->each(function($m){
			$m->delete();
		});

		if($this->remove_everything){

			$item =$this->add('xepan\commerce\Model_Item')->each(function($m){
				$m->delete();
			});
			$this->add('xepan\commerce\Model_Item_Specification')->each(function($m){
				$m->delete();
			});

			$this->add('xavoc\mlm\Model_Payout')->deleteAll();
			$this->add('xavoc\mlm\Model_Closing')->deleteAll();

			// add default specifications
			$specfic_array=['BV','SV','PV','Capping','Introduction Income'];
			foreach ($specfic_array as $sp) {
				$this->add('xepan\commerce\Model_Item_Specification')
						->addCondition('name',$sp)
						->tryLoadAny()
						->save();
			}

			$item_array=[
						['name'=>'Health Care Product','code'=> 'Package A1','pv'=>'0','bv'=>'200','sv'=>'0','capping'=>'5000','introducer_income'=>'50'],
						['name'=>'Health Care Product','code'=> 'Package A2','pv'=>'0','bv'=>'200','sv'=>'0','capping'=>'5000','introducer_income'=>'50'],
						['name'=>'Health Care Product','code'=> 'Package A3','pv'=>'0','bv'=>'200','sv'=>'0','capping'=>'5000','introducer_income'=>'50'],
						['name'=>'Health Care Product','code'=> 'Package A4','pv'=>'0','bv'=>'200','sv'=>'0','capping'=>'5000','introducer_income'=>'50'],
						['name'=>'Health Care Product','code'=> 'Package A5','pv'=>'0','bv'=>'200','sv'=>'0','capping'=>'5000','introducer_income'=>'50'],
						['name'=>'Health Care Product','code'=> 'Package A6','pv'=>'0','bv'=>'200','sv'=>'0','capping'=>'5000','introducer_income'=>'50'],
						['name'=>'Health Care Product','code'=> 'Package A7','pv'=>'0','bv'=>'200','sv'=>'0','capping'=>'5000','introducer_income'=>'50'],
						['name'=>'Health Care Product','code'=> 'Package A8','pv'=>'0','bv'=>'200','sv'=>'0','capping'=>'5000','introducer_income'=>'50'],
						['name'=>'Health Care Product','code'=> 'Package A9','pv'=>'0','bv'=>'200','sv'=>'0','capping'=>'5000','introducer_income'=>'50'],
						['name'=>'Health Care Product','code'=> 'Package A10','pv'=>'0','bv'=>'200','sv'=>'0','capping'=>'5000','introducer_income'=>'50'],
						['name'=>'Health Care Product','code'=> 'Package A11','pv'=>'0','bv'=>'200','sv'=>'0','capping'=>'5000','introducer_income'=>'50'],
						['name'=>'DS Tobak Kit','code'=> 'Package A12','pv'=>'0','bv'=>'200','sv'=>'0','capping'=>'5000','introducer_income'=>'50'],
						['name'=>'DS Alco Kit','code'=> 'Package A13','pv'=>'0','bv'=>'200','sv'=>'0','capping'=>'5000','introducer_income'=>'50'],

						['name'=>'Male/Female Immune Kit','code'=> 'Package B1','pv'=>'0','bv'=>'700','sv'=>'0','capping'=>'10000','introducer_income'=>'150'],
						['name'=>'Child Immune Kit','code'=> 'Package B2','pv'=>'0','bv'=>'700','sv'=>'0','capping'=>'10000','introducer_income'=>'150'],
						['name'=>'Remove Tobacco Addiction kit','code'=> 'Package B3','pv'=>'0','bv'=>'700','sv'=>'0','capping'=>'10000','introducer_income'=>'150'],
						['name'=>'Remove Alcohol Addiction kit','code'=> 'Package B4','pv'=>'0','bv'=>'700','sv'=>'0','capping'=>'10000','introducer_income'=>'150'],
						['name'=>'Hair Treatment kit','code'=> 'Package B5','pv'=>'0','bv'=>'700','sv'=>'0','capping'=>'10000','introducer_income'=>'150'],
						['name'=>'Skin Treatment kit','code'=> 'Package B6','pv'=>'0','bv'=>'700','sv'=>'0','capping'=>'10000','introducer_income'=>'150'],
						['name'=>'Joint Care kit','code'=> 'Package B7','pv'=>'0','bv'=>'700','sv'=>'0','capping'=>'10000','introducer_income'=>'150'],

						['name'=>'General Health Care Kit','code'=> 'Package C1','pv'=>'0','bv'=>'1500','sv'=>'0','capping'=>'15000','introducer_income'=>'300'],
						['name'=>'DS Promotional Kit','code'=> 'Package C2','pv'=>'0','bv'=>'1500','sv'=>'0','capping'=>'15000','introducer_income'=>'300'],

						['name'=>'DS King-Size Product Kit','code'=> 'Package D1','pv'=>'0','bv'=>'3200','sv'=>'0','capping'=>'25000','introducer_income'=>'600']
			];
			foreach ($item_array as $item) {
				$kit = $this->add('xavoc\mlm\Model_Kit')
						->addCondition('sku',$item['code'])
						->tryLoadAny();
				$kit->set('name',$item['name'])
					->set('pv',$item['pv'])
					->set('bv',$item['bv'])
					->set('sv',$this->importing_old_data?0:$item['sv'])
					->set('capping',$item['capping'])
					->set('introducer_income',$item['introducer_income'])
					->save();
			}

			$re_purchase_slab = [
				['name'=>null,			'slab_percentage'=>0,	'from_bv'=>0, 		'to_bv'=>200],
				['name'=>'Star',		'slab_percentage'=>5,	'from_bv'=>201, 	'to_bv'=>10000],
				['name'=>'Yellow Star',	'slab_percentage'=>10,	'from_bv'=>10001, 	'to_bv'=>35000],
				['name'=>'Orange Star',	'slab_percentage'=>15,	'from_bv'=>35001, 	'to_bv'=>100000],
				['name'=>'Red Star',	'slab_percentage'=>20,	'from_bv'=>100001, 	'to_bv'=>250000],
				['name'=>'Purpule Star','slab_percentage'=>25,	'from_bv'=>250001, 	'to_bv'=>500000],
				['name'=>'Green Star',	'slab_percentage'=>30,	'from_bv'=>500001, 	'to_bv'=>2500000],
				['name'=>'Brown Star',	'slab_percentage'=>35,	'from_bv'=>2500001, 'to_bv'=>5000000],
				['name'=>'Blue Star',	'slab_percentage'=>40,	'from_bv'=>5000001, 'to_bv'=>5000000000],
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

			$loyalti_bonus_slab = [
				['name'=>'Brown Star','distribution_percentage'=>2.5,'turnover_criteria'=>2500000],
				['name'=>'Blue Star','distribution_percentage'=>2.5,'turnover_criteria'=>5000000]
			];

			foreach ($loyalti_bonus_slab as $row) {
				$slab = $this->add('xavoc\mlm\Model_LoyaltiBonusSlab')
							->addCondition('name',$row['name'])
							->tryLoadAny();
				foreach ($row as $field => $value) {
					$slab[$field]=$value;
				}

				$slab['rank_id'] = $this->add('xavoc\mlm\Model_RePurchaseBonusSlab')->loadBy('name',$row['name'])->get('id');
				$slab->save();
			}
		}
		

		$this->app->skip_sponsor_introducer_mandatory = true;
		$this->setupCompany();
		$this->app->skip_sponsor_introducer_mandatory = false;
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
		$dis['sponsor_id']=0;
		$dis['introducer_id']=0;
		$dis->save();

	}
}