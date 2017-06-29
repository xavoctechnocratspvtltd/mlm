<?php

namespace xavoc\mlm;


/**
* 
*/
class Tool_Register extends \xavoc\mlm\Tool_Distributor{
	
	public $options = [
				'show_caption'=>true,
				'registration_message'=>'Registration mail sent. Check your email address linked to the account.',
				'after_registration_redirect_url'=>null,
				'show_kit'=>true,
			];
	
	function init(){
		parent::init();

		if($this->owner instanceof \AbstractController) return;

		$form_field = ['introducer_id','side','first_name','last_name','dob','email','mobile_number','pan_no','country_id','state_id','city','pin_code','address'];
		$form = $this->add('Form');
		$form->setLayout(['view/form/registration']);
		$form->setModel('xavoc\mlm\Distributor',$form_field);
		
		foreach ($form_field as $key => $name) {
			if(in_array($name, ['pan_no'])) continue;
			$form->getElement($name)->validate('required');
		}
		
		$country_field = $form->getElement('country_id');
		$state_field = $form->getElement('state_id');
		if($_GET['country_id']){
			$state_field->getModel()->addCondition('country_id',$_GET['country_id']);
		}
		$country_field->js('change',$state_field->js()->reload(null,null,[$this->app->url(null,['cut_object'=>$state_field->name]),'country_id'=>$country_field->js()->val()]));
		// $country_field->js('change',$form->js()->atk4_form('reloadField','state_id',[$this->app->url(null,['cut_object'=>$state_field->name]),'country_id'=>$country_field->js()->val()]));
		

		$form->addField('username')->validate('required');
		$form->addField('password','password')->validate('required');	
		$form->addField('password','retype_password')->validate('required');	
		$form->addSubmit('Register')->addClass(' btn btn-primary btn-block');
		
		if($form->isSubmitted()){

			if($form['password'] !== $form['retype_password'])
				$form->displayError('retype_password','Password Not Match');

			try{
				$this->api->db->beginTransaction();

				$distributor = $this->add('xavoc\mlm\Model_Distributor');
				$distributor->register($form->get());
				
				$this->api->db->commit();
				$form->js()->reload()->univ()->successMessage('Saved')->execute();
			}catch(\Exception $e){
				$this->api->db->rollback();
				$form->js()->reload()->univ()->errorMessage($e->getMessage())->execute();
			}

		}

	}
}