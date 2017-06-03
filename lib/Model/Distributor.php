<?php

namespace xavoc\mlm;


class Model_Distributor extends \xepan\commerce\Model_Customer {

	public $status = ['Active','InActive'];
	public $actions = [
				'Active'=>['view','edit','delete'],
				'InActive'=>['view','edit','delete','active']
				];
	public $acl_type= "ispmanager_distributor";

	function init(){
		parent::init();

		$dist_j = $this->join('mlm_distributor.customer_id');

		$dist_j->hasOne('xavoc\mlm\Sponsor','sponsor_id')->display(['form'=>'xepan\base\DropDownNormal']);
		$dist_j->hasOne('xavoc\mlm\Introducer','introducer_id')->display(['form'=>'xepan\base\DropDownNormal']);

		$dist_j->hasOne('xavoc\mlm\Left','left_id')->display(['form'=>'xepan\base\DropDownNormal']);
		$dist_j->hasOne('xavoc\mlm\Right','right_id')->display(['form'=>'xepan\base\DropDownNormal']);

		$dist_j->addField('path')->type('text');
		$dist_j->addField('side')->enum(['A','B']);

		$dist_j->hasOne('xavoc\mlm\Kit','kit_item_id')->defaultValue(null)->caption('Startup Package');
		$dist_j->addField('capping')->type('int')->system(true);

		$dist_j->addField('IFCS_Code')->mandatory("IFSC Code is required")->display(array('form'=>'AlphaNumeric'))->caption('IFSC Code');
		$dist_j->addField('branch_name')->caption('Branch')->mandatory("Branch name is required")->display(array('form'=>'Alpha'));//->system(true);
		$dist_j->addField('kyc_no')->mandatory("KYC no is required")->caption('KYC no.');
		$dist_j->add('filestore/Field_Image','kyc_id')->caption('KYC form');
		$dist_j->add('filestore/Field_Image','address_proof_id')->caption('Address proof');
		$dist_j->addField('nominee_name')->mandatory("Nominee name is required")->display(array('form'=>'Alpha'))->caption('Nominee name');
		$dist_j->addField('relation_with_nominee')->enum(explode(",", $config['relations_with_nominee']))->mandatory("Relation with nominee is required")->caption('Relation with Nominee');//->system(true);
		$dist_j->addField('nominee_email')->caption('Nominee email')->display(array('form'=>'Email'));//->system(true);
		$dist_j->addField('nominee_age')->mandatory("Nominee age is required")->display(array('form'=>'xMLM/Range'))->caption("Nominee age");


		// weekly session
		$dist_j->addField('weekly_intros_amount')->type('money')->defaultValue(0);
		$dist_j->addField('total_intros_amount')->type('money')->defaultValue(0);

		$dist_j->addField('weekly_left_sv')->type('int')->defaultValue(0);
		$dist_j->addField('weekly_right_sv')->type('int')->defaultValue(0);

		$dist_j->addField('total_left_sv')->type('int')->defaultValue(0);
		$dist_j->addField('total_right_sv')->type('int')->defaultValue(0);

		// monthly session
		$dist_j->addField('monthly_left_dp_mrp_diff')->type('int')->defaultValue(0);
		$dist_j->addField('monthly_right_dp_mrp_diff')->type('int')->defaultValue(0);

		$this->hasMany('xavoc\mlm\GenerationBusiness','distributor_id');

		/*
			Need a few more fields based on plan and calculations
			
			Self,
	
			Left & Right		
			Small-Session : Day, Week, Fortnight
			Session is Default 'Main Closing' to closing duration
			Big-Session : Month, Quarter, Yearly
	

			BV, PV, SV,


		*/
		
		
	}


	function register($data){
		// throw new \Exception("Error Processing Request", 1);
	}
} 