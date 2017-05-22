<?php

namespace xavoc\mlm;


class Model_Distributor extends \xepan\commerce\Model_Customer {

	// public $table = "isp_user";
	public $status = ['Active','InActive'];
	public $actions = [
				'Active'=>['view','edit','delete'],
				'InActive'=>['view','edit','delete','active']
				];
	public $acl_type= "ispmanager_distributor";

	function init(){
		parent::init();

		// $destroy_field = ['assign_to_id','scope','user_id','is_designer','score','freelancer_type','related_with','related_id','assign_to','created_by_id','source'];
		// foreach ($destroy_field as $key => $field) {
		// 	if($this->hasElement($field))
		// 		$this->getElement($field)->system(true);
		// }

		$dist_j = $this->join('mlm_distributor.customer_id');

		$dist_j->hasOne('xavoc\mlm\Sponsor','sponsor_id')->display(['form'=>'xepan\base\DropDownNormal']);
		$dist_j->hasOne('xavoc\mlm\Introducer','introducer_id')->display(['form'=>'xepan\base\DropDownNormal']);

		$dist_j->addField('path')->type('text');
		$dist_j->addField('side')->enum(['A','B']);
		// $dist_j->hasOne('xavoc\mlm\Pin','pin_id');
		
	}


	function register($data){
		// throw new \Exception("Error Processing Request", 1);
	}
} 