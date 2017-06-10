<?php

namespace xavoc\mlm;


/**
* 
*/
class Tool_Register extends \xepan\cms\View_Tool{
	
	public $options = [
				'show_caption'=>true,
				'registration_message'=>'Registration mail sent. Check your email address linked to the account.',
				'after_registration_redirect_url'=>null,
				'show_kit'=>true,
			];
	
	function init(){
		parent::init();

		$form = $this->add('Form');
		$form->setLayout(['view/form/registration']);
		$form->setModel('xavoc\mlm\Distributor',['first_name','last_name','introducer_id','side','email','mobile_number','pan_no','address','dob','username','password']);
		$form->getElement('first_name')->validate('required');
		$form->getElement('last_name')->validate('required');
		$form->getElement('introducer_id')->validate('required');
		$form->getElement('side')->validate('required');
		$form->getElement('dob')->validate('required');
		$form->getElement('pan_no')->validate('required');
		$form->getElement('email')->validate('required');
		$form->getElement('mobile_number')->validate('required');
		$form->getElement('address')->validate('required');
		$form->addField('username')->validate('required|email');
		$form->addField('password','password')->validate('required');
		// $form->addField('xepan\base\DropDownNormal','sponsor')->setModel('xavoc\mlm\Distributor');
		// $form->addField('xepan\base\DropDownNormal','introducer')->setModel('xavoc\mlm\Distributor');
		$form->addSubmit('Register')->addClass(' btn btn-primary btn-block');
		
		if($form->isSubmitted()){
			$distributor = $this->add('xavoc\mlm\Model_Distributor');
			$distributor->register($form->get());
			$form->js()->reload()->univ()->successMessage('Saved')->execute();
		}
	}
}