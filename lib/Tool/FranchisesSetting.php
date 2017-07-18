<?php

namespace xavoc\mlm;

class Tool_FranchisesSetting extends \xepan\cms\View_Tool{
	public $options = ['login_page'=>'login'];

	function init(){
		parent::init();
		
		if($this->owner instanceof \AbstractController) return;
		
		$this->addClass('main-box');
		
		$this->franchises = $franchises = $this->add('xavoc\mlm\Model_Franchises');
		$this->franchises->loadLoggedIn();

		$tab = $this->add('Tabs');
		$pass_tab = $tab->addTab('Change Password');
		$profile_tab = $tab->addTab('Profile');

		// change password -------
		$user = $pass_tab->add('xepan\base\Model_User')->load($this->api->auth->model->id);
		$this->api->auth->addEncryptionHook($user);
		
		$change_pass_form = $pass_tab->add('Form');
		$change_pass_form->addField('user_name')->set($user['username'])->setAttr('disabled',true);
		$change_pass_form->addField('password','old_password')->validate('required');
		$change_pass_form->addField('password','new_password')->validate('required');
		$change_pass_form->addField('password','retype_password')->validate('required');
		$change_pass_form->addSubmit('Change Password')->addClass('btn btn-primary');

		if($change_pass_form->isSubmitted()){
			if( $change_pass_form['new_password'] != $change_pass_form['retype_password'])
				$change_pass_form->displayError('new_password','password not match');
			
			if(!$this->api->auth->verifyCredentials($user['username'],$change_pass_form['old_password']))
				$change_pass_form->displayError('old_password','password not match');

			if($user->updatePassword($change_pass_form['new_password'])){
				$this->app->auth->logout();
				$this->app->redirect($this->options['login_page']);
				// $change_pass_form->js()->univ()->successMessage('Password Changed Successfully')->execute();
			}
			$change_pass_form->js()->univ()->errorMessage('some thing happen wrong')->execute();
		}

		$col = $profile_tab->add('Columns')->addClass('row');
		$col1 = $col->addColumn(6)->addClass('col-md-6 col-lg-6 col-sm-12 col-xs-12');
		$col2 = $col->addColumn(6)->addClass('col-md-6 col-lg-6 col-sm-12 col-xs-12');

		$form = $col1->add('Form');
		$form->setModel($this->franchises,['name','country_id','state_id','city','address','pin_code']);
		
		$state_field = $form->getElement('state_id');
		if($_GET['country_id']){
			$state_field->getModel()->addCondition('country_id',$_GET['country_id']);
		}
		$country_field = $form->getElement('country_id');
		$country_field->js('change',$form->js()->atk4_form('reloadField','state_id',[$this->app->url(null,['cut_object'=>$state_field->name]),'country_id'=>$country_field->js()->val()]));
		$form->addSubmit('Update')->addClass('btn btn-primary');

		if($form->isSubmitted()){
			$form->save();
			$form->js()->univ()->successMessage('saved')->execute();
		}

		$cp_model = $col2->add('xepan\base\Model_Contact_Phone');
		$cp_model->addCondition('contact_id',$this->franchises->id);
		$cp_model->addCondition('is_active',true);
		$cp_model->addCondition('is_valid',true);
		$cp_model->addCondition('head','Official');

		$crud = $col2->add('CRUD',['entity_name'=>"Phone"]);
		$crud->setModel($cp_model,['value']);
		$crud->grid->addPaginator($ipp=5);

		$cp_model = $col2->add('xepan\base\Model_Contact_Email');
		$cp_model->addCondition('contact_id',$this->franchises->id);
		$cp_model->addCondition('is_active',true);
		$cp_model->addCondition('is_valid',true);
		$cp_model->addCondition('head','Official');

		$col2->add('View')->setElement('hr');
		$crud = $col2->add('CRUD',['entity_name'=>"Email"]);
		$crud->setModel($cp_model,['value']);
		$crud->grid->addPaginator($ipp=5);
	}

}