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
		$this->app->stickyGET('country_id');

		$this->distributor = $distributor = $this->add('xavoc\mlm\Model_Distributor');
		$distributor->loadLoggedIn();
		if(!$distributor->loaded()) return "distributor is not loaded";

		$tabs = $this->add('Tabs');
		$doc_tab = $tabs->addTab('Document');
		$profile_tab = $tabs->addTab('Profile');
		$pass_tab = $tabs->addTab('Change Password');

		// attachment tabs
		$attachment = $this->add('xavoc\mlm\Model_Attachment');
		$attachment->addCondition('distributor_id',$distributor->id);
		$attachment->tryLoadAny();
		if($attachment->count()->getOne() > 1){
			$doc_tab->add('View_Error')->set("more thenn one kyc attachment found");
		}else{
			$form = $doc_tab->add('Form');
			$form->setModel($attachment,['pan_card_id','aadhar_card_id','driving_license_id']);
			$form->addField('bank_account_number')->validate('required');
			$form->addField('bank_name')->validate('required');
			$form->addField('bank_ifsc_code')->validate('required');

			$form->addSubmit("Update")->addClass('btn btn-primary');
			if($form->isSubmitted()){
				if(!$form['pan_card_id']) $form->error('pan_card_id','pan card id must not be empty');
				if(!$form['aadhar_card_id']) $form->error('aadhar_card_id','aadhar card id must not be empty');
				
				$form->update();

				$distributor['d_account_number'] = $form['bank_account_number'];
				$distributor['d_bank_name'] = $form['bank_name'];
				$distributor['d_bank_ifsc_code'] = $form['bank_ifsc_code'];
				$distributor->save();

				$form->js()->univ()->successMessage('saved')->execute();
			}
		}
		// end of tabs

		// profile 
		$col = $profile_tab->add('Columns');
		$left = $col->addColumn(8);
		$pro_fields = ['dob','country_id','state_id','city','address','pin_code','image_id','image'];
		$form = $left->add('Form');
		$form->add('View')->setHtml("<strong>Name: </strong><br/> ".$distributor['first_name']." ".$distributor['last_name']);
		// $f_c = $form->add('Columns');
		// $a = $f_c->addColumn('4');
		// $b = $f_c->addColumn('4');
		// $c = $f_c->addColumn('4');
		$form->setLayout(['view/form/profile']);
		$form->setModel($distributor,$pro_fields);
		// $form->getElement('dob')->setAttr('disabled',true);
		// $img_view = $form->add('View')->setHtml('<img src="'.$distributor['image'].'"/>');
		// $img_field= $form->getElement('image_id');
		// $img_field->js('change',$img_view->js()->reload());

		$country_field = $form->getElement('country_id');
		$country_field->validate('required');
		
		$state_field = $form->getElement('state_id');
		$state_field->validate('required');
		$form->getElement('city')->validate('required');
		$form->getElement('address')->validate('required');
		$form->getElement('pin_code')->validate('required');

		if($_GET['country_id']){
			$state_field->getModel()->addCondition('country_id',$_GET['country_id']);
		}
		$country_field->js('change',$state_field->js()->reload(null,null,[$this->app->url(null,['cut_object'=>$state_field->name]),'country_id'=>$country_field->js()->val()]));
		// $country_field->js('change',$form->js()->atk4_form('reloadField','state_id',[$this->app->url(null,['cut_object'=>$state_field->name]),'country_id'=>$country_field->js()->val()]));

		$form->addSubmit('Update')->addClass('btn btn-primary');

		if($form->isSubmitted()){
			if($distributor->isRoot()) $this->app->skip_sponsor_introducer_mandatory = true;
			$dis = $this->add('xavoc\mlm\Model_Distributor')->load($distributor->id);
			foreach ($pro_fields as $key => $field_name) {
				$dis[$field_name] = $form[$field_name];	
			}
			$dis->save();
			$this->app->skip_sponsor_introducer_mandatory = false;
			$js_event = [
				$form->js()->reload(),
				$form->js(true)->_selector('img.ds-dp')->attr('src',$dis['image'])
			];
			$form->js(null,$js_event)->univ()->successMessage('saved')->execute();

		}

		$right = $col->addColumn(4);

		// end of profile


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