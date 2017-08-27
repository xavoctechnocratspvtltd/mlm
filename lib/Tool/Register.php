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

		$this->app->stickyGET('new_dist_id');

		$v = $this->add('View');

		if($_GET['new_dist_id']){
			$new_dis = $this->add('xavoc\mlm\Model_Distributor')->load($_GET['new_dist_id']);
			$v->add('View')->addClass('alert alert-success text-center')->setHtml('<h4>Registration done successfully. User Id:<strong>'.$new_dis['user']."</strong>, Password: <strong>".$new_dis['password']."</strong></h4>");
		}

		$form_field = ['introducer_id','side','first_name','last_name','dob','email','mobile_number','pan_no','country_id','state_id','city','pin_code','address','d_account_number','d_bank_name','d_bank_ifsc_code','nominee_name','relation_with_nominee','aadhar_card_number','d_account_type'];
		$form = $this->add('Form');
		$form->add('xepan\base\Controller_FLC')
		->addContentSpot()
		->layout([
				'introducer'=>'PLACEMENT DETAILS~c1~6',
				'side'=>'~c2~6',
				'first_name'=>'PERSONAL DETAILS~c1~4',
				'last_name'=>'c2~4',
				'dob'=>'c3~4',
				'email'=>'c4~4',
				'mobile_number'=>'c5~4',
				'aadhar_card_number'=>'c6~4',
				'country_id~Country'=>'c7~3',
				'state_id~State'=>'c8~3',
				'city'=>'c9~3',
				'pin_code'=>'c10~3',
				'address'=>'c11~12',
				'nominee_name'=>'NOMINEE DETAILS~c1~4',
				'relation_with_nominee'=>'c2~4',
				'nominee_mobile_number'=>'c3~4',
				'd_bank_name~Bank Name'=>'BANK DETAILS~c1~3',
				'd_account_number~Account Number'=>'c2~3',
				'd_bank_ifsc_code~Bank IFSC'=>'c3~3',
				'd_account_type~Account Type'=>'c4~3',
				'pan_no'=>'c5~12',

			]
			);
		// $form->setLayout(['view/form/registration']);
		$form->setModel('xavoc\mlm\Distributor',$form_field);
		
		foreach ($form_field as $key => $name) {
			if(in_array($name, ['pan_no','d_account_number','d_bank_name','d_bank_ifsc_code','nominee_name','relation_with_nominee','aadhar_card_number','d_account_type'])) continue;
			$form->getElement($name)->validate('required');
		}

		$form->getElement('address')->setAttr('style','width:100%');
		$form->getElement('side')->setAttr('style','width:40%');
		$form->getElement('aadhar_card_number')->js(true)->_load('jquery.maskedinput.min')->mask('****-****-****-****');
		
		$country_field = $form->getElement('country_id');
		$state_field = $form->getElement('state_id');
		if($_GET['country_id']){
			$state_field->getModel()->addCondition('country_id',$_GET['country_id']);
		}else{
			$state_field->getModel()->addCondition('country_id',100);// india
		}
		$country_field->js('change',$state_field->js()->reload(null,null,[$this->app->url(null,['cut_object'=>$state_field->name]),'country_id'=>$country_field->js()->val()]));
		// $country_field->js('change',$form->js()->atk4_form('reloadField','state_id',[$this->app->url(null,['cut_object'=>$state_field->name]),'country_id'=>$country_field->js()->val()]));
		

		// $form->addField('username')->validate('required');
		// $form->addField('password','password')->validate('required');	
		// $form->addField('password','retype_password')->validate('required');	
		$form->addSubmit('Register')->addClass(' btn btn-primary btn-block');
		
		if($form->isSubmitted()){

			if($form['password'] !== $form['retype_password'])
				$form->displayError('retype_password','Password Not Match');

			try{
				$this->api->db->beginTransaction();

				$distributor = $this->add('xavoc\mlm\Model_Distributor');
				$distributor->register($form->get());
				
				$this->api->db->commit();
				$v->js(null,[$form->js()->reload(),$v->js()->reload(['new_dist_id'=>$distributor->id])])->univ()->successMessage('Registration Successfully')->execute();
			}catch(\Exception $e){
				$this->api->db->rollback();
				$form->js()->univ()->errorMessage($e->getMessage())->execute();
			}

		}

	}
}