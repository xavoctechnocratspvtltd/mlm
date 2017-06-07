<?php

namespace xavoc\mlm;

/**
* 
*/
class Tool_Profile extends \xepan\cms\View_Tool{
	public $options = [];
	
	function init(){
		parent::init();

		$this->distributor = $distributor = $this->add('xavoc\mlm\Model_Distributor');
		$distributor->loadLoggedIn();
		if(!$distributor->loaded()) return "distributor is not loaded";
		
		$kyc = $this->add('xavoc\mlm\Model_KYC');
		if($distributor['kyc_id']){
			$kyc->load($distributor['kyc_id']);
		}

		$form = $this->add('Form');
		$form->setModel($kyc);
		$form->addSubmit("Update");
		if($form->isSubmitted()){
			$form->update();
			if(!$distributor['kyc_id']){
				$distributor['kyc_id'] = $form->model->id;
				$distributor->save();
			}
		}

	}
}