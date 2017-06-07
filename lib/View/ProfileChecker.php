<?php

namespace xavoc\mlm;

/**
* it checks profile updated in percentage
*/

class View_ProfileChecker extends \xepan\cms\View_Tool{
	public $options = [
				'kit_purchase_page'=>'kit',
				'kyc_purchase_page'=>'profile',
			];

	function init(){
		parent::init();

		$this->distributor = $distributor = $this->add('xavoc\mlm\Model_Distributor');
		$distributor->loadLoggedIn();
		if(!$distributor->loaded()){
			return "distributor not found";
		}
		
		// check kit is purchased or not
		// check kyc form is updated or not
		// distributor is verified or not
		$complete_percentage = '0';
		// $distributor['kit_item_id'] = 90;
		if($distributor['kit_id']) $complete_percentage += '20';
		if($distributor['kyc_id']) $complete_percentage += '40';
		if($distributor['is_verified']) $complete_percentage += '40';

		$this->template->set('profile_percentage',$complete_percentage."%");

		if($complete_percentage > 0)
			$this->template->tryDel('not_found');

		if(!$distributor['kit_item_id']){
			$this->add('Button')->set('Purchase Kit Now')->addClass('btn btn-primary')->js('click')->univ()->redirect($this->app->url($this->options['kit_purchase_page']));
		}
		if(!$distributor['is_kyc_updated']){
			$this->add('Button')->set('Update KYC')->addClass('btn btn-primary')->js('click')->univ()->redirect($this->app->url($this->options['kyc_purchase_page']));
		}
		if(!$distributor['is_verified']){
			$this->add('View_Box')->addClass('alert alert-info')->set('You are under admin verification process');
		}
	}

	function defaultTemplate(){
		return ['xavoc\view\profilechecker'];
	}
}