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
		
		$attachment = $this->add('xavoc\mlm\Model_Attachment');
		$attachment->addCondition('distributor_id',$distributor->id);
		$attachment->tryLoadAny();
		if($attachment->count()->getOne() > 1) throw new \Exception("more thenn one kyc attachment found");		

		$form = $this->add('Form');
		$form->setModel($attachment,['pan_card_id','aadhar_card_id']);
		$form->addSubmit("Update");
		if($form->isSubmitted()){
			$form->update();
			$form->js()->univ()->successMessage('saved');
		}

	}
}