<?php

namespace xavoc\mlm;

/**
* 
*/
class Tool_Profile extends \xepan\cms\View_Tool{
	public $options = ['login_page'=>'login'];
	
	function init(){
		parent::init();

		$this->addClass('main-box');
		
		$this->distributor = $distributor = $this->add('xavoc\mlm\Model_Distributor');
		$distributor->loadLoggedIn();
		if(!$distributor->loaded()) return "distributor is not loaded";

		$tabs = $this->add('Tabs');
		$doc_tab = $tabs->addTab('Document');
		$profile_tab = $tabs->addTab('Profile');
		$pass_tab = $tabs->addTab('Change Password');


		$attachment = $this->add('xavoc\mlm\Model_Attachment');
		$attachment->addCondition('distributor_id',$distributor->id);
		$attachment->tryLoadAny();
		if($attachment->count()->getOne() > 1){
			$doc_tab->add('View_Error')->set("more thenn one kyc attachment found");
		}else{
			$form = $doc_tab->add('Form');
			$form->setModel($attachment,['pan_card_id','aadhar_card_id']);
			$form->addSubmit("Update")->addClass('btn btn-primary');
			if($form->isSubmitted()){
				$form->update();
				$form->js()->univ()->successMessage('saved')->execute();
			}
		}


		// change distributor password -------
		$user = $pass_tab->add('xepan\base\Model_User')->load($this->api->auth->model->id);
		$this->api->auth->addEncryptionHook($user);
		
		$change_pass_form = $pass_tab->add('Form');
		$change_pass_form->addField('user_name')->set($user['username'])->setAttr('disabled',true);
		$change_pass_form->addField('password','old_password')->validate('required');
		$change_pass_form->addField('password','new_password')->validate('required');
		$change_pass_form->addField('password','retype_password')->validate('required');
		$change_pass_form->addSubmit('Update Password')->addClass('btn btn-primary');

		if($change_pass_form->isSubmitted()){
			if( $change_pass_form['new_password'] != $change_pass_form['retype_password'])
				$change_pass_form->displayError('old_password','Password not match');
			
			if(!$this->api->auth->verifyCredentials($user['username'],$change_pass_form['old_password']))
				$change_pass_form->displayError('old_password','Password not match');

			if($user->updatePassword($change_pass_form['new_password'])){
				$this->app->auth->logout();
				$this->app->redirect($this->options['login_page']);
				// $change_pass_form->js()->univ()->successMessage('Password Changed Successfully')->execute();
			}
			$change_pass_form->js()->univ()->errorMessage('some thing happen wrong')->execute();
		}
		// end ---------------
	}
}