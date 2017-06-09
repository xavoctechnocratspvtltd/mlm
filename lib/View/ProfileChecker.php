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
		$distributor->addExpression('attachment_count')->set(function($m,$q){
			return $q->expr('IFNULL([0],0)',[$m->refSQL('xavoc\mlm\Attachment')->count()]);
		});

		$distributor->loadLoggedIn();
		if(!$distributor->loaded()){
			return "distributor not found";
		}
		
		// check kit is purchased or not
		// check kyc form is updated or not
		// distributor is verified or not
		$complete_percentage = '0';
		// $distributor['kit_item_id'] = 90;
		if($distributor['kit_item_id']) $complete_percentage += '40';
		if($distributor['attachment_count']) $complete_percentage += '40';
		if($distributor['is_verified']) $complete_percentage += '20';

		$this->template->set('profile_percentage',$complete_percentage."%");

		if($complete_percentage > 0)
			$this->template->tryDel('not_found');
		
		if(!$distributor['kit_item_id']){
			$this->add('Button',null,'kit_info')->set('Purchase Kit Now')->addClass('btn btn-warning btn-block alert')->js('click')->univ()->redirect($this->app->url($this->options['kit_purchase_page']));
		}else{
			$this->add('View_Box',null,'kit_info')->setHTML('<i class="glyphicon glyphicon-ok"></i> Your Startup Package is <b>'.$distributor['kit_item']."</b>")->addClass('alert alert-success');
		}
		
		if(!$distributor['attachment_count']){
			$this->add('Button',null,'kyc_info')->set('Update KYC')->addClass('btn btn-primary')->js('click')->univ()->redirect($this->app->url($this->options['kyc_purchase_page']));
		}else{ 
			$this->add('View_Box',null,'kyc_info')->setHTML('<i class="glyphicon glyphicon-ok"></i> You Updated Your KYC')->addClass('alert alert-success');
		}

		if(!$distributor['is_verified']){
			$this->add('View_Box',null,'verification_info')->addClass('alert alert-info')->set('You are under admin verification process');
		}
	}

	function defaultTemplate(){
		return ['xavoc\view\profilechecker'];
	}
}