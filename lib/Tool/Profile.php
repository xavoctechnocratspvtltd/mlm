<?php

namespace xavoc\mlm;

/**
* 
*/
class Tool_Profile extends \xavoc\mlm\Tool_Distributor{
	public $options = ['login_page'=>'login'];
	
	function init(){
		parent::init();

		if($this->owner instanceof \AbstractController) return;

		$this->addClass('main-box');
		$this->app->stickyGET('country_id');

		$this->distributor = $distributor = $this->add('xavoc\mlm\Model_Distributor');
		$distributor->loadLoggedIn();
		if(!$distributor->loaded()) return "distributor is not loaded";

		$tabs = $this->add('Tabs');
		// $doc_tab = $tabs->addTab('Document');
		$profile_tab = $tabs->addTab('Profile');
		$pass_tab = $tabs->addTab('Change Password');

		// // attachment tabs
		// $attachment = $this->add('xavoc\mlm\Model_Attachment');
		// $attachment->addCondition('distributor_id',$distributor->id);
		// $attachment->tryLoadAny();
		// if($attachment->count()->getOne() > 1){
		// 	$doc_tab->add('View_Error')->set("more thenn one kyc attachment found");
		// }else{
		// 	$form = $doc_tab->add('Form');
		// 	$form->addField('pan_no')->validate('required')->set($distributor['pan_no']);
		// 	$form->setModel($attachment,['pan_card_id','aadhar_card_id','driving_license_id']);
		// 	$form->addField('bank_account_number')->validate('required');
		// 	$form->addField('bank_name')->validate('required');
		// 	$form->addField('bank_ifsc_code')->validate('required');

		// 	$form->addSubmit("Update")->addClass('btn btn-primary');
		// 	if($form->isSubmitted()){
		// 		if(!$form['pan_card_id']) $form->error('pan_card_id','pan card id must not be empty');
		// 		if(!$form['aadhar_card_id']) $form->error('aadhar_card_id','aadhar card id must not be empty');
				
		// 		$form->update();

		// 		$distributor['pan_no'] = $form['pan_no'];
		// 		$distributor['d_account_number'] = $form['bank_account_number'];
		// 		$distributor['d_bank_name'] = $form['bank_name'];
		// 		$distributor['d_bank_ifsc_code'] = $form['bank_ifsc_code'];
		// 		$distributor->save();

		// 		$form->js()->univ()->successMessage('saved')->execute();
		// 	}
		// }
		// end of tabs

		// profile
		$col = $profile_tab->add('Columns');
		$pro_fields = ['first_name','last_name','dob','email','mobile_number','pan_no','country_id','country','state_id','state','city','address','pin_code','image_id','nominee_name','relation_with_nominee','nominee_mobile_number','aadhar_card_number','d_account_number','d_bank_name','d_bank_ifsc_code','d_account_type'];
		$form = $col->add('Form');
		$form->add('xepan\base\Controller_FLC')
		->addContentSpot()
		->layout([
				'first_name'=>'PERSONAL DETAILS~c1~4',
				'last_name'=>'c2~4',
				'dob~Date Of Birth'=>'c3~4',
				'country_id~Country'=>'c8~4',
				'country~'=>'c8~4',
				'state_id~State'=>'c9~4',
				'state~'=>'c9~4',
				'city'=>'c10~3',
				'pin_code'=>'c11~1',
				'address'=>'c12~12',
				'email'=>'c4~3',
				'mobile_number'=>'c5~3',
				'aadhar_card_number'=>'c6~3',
				'pan_no'=>'c7~3',
				'nominee_name'=>'NOMINEE DETAILS~c1~4',
				'relation_with_nominee'=>'c2~4',
				'nominee_mobile_number'=>'c3~4',
				'd_bank_name~Bank Name'=>'BANK DETAILS~c1~3',
				'd_account_number~Account Number'=>'c2~3',
				'd_bank_ifsc_code~Bank IFSC'=>'c3~3',
				'd_account_type~Account Type'=>'c4~3',
				'image_id'=>'PROFILE PICTURE~c1~12',
				'pan_card_id'=>'DOCUMENTS~c1~3',
				'aadhar_card_id'=>'c2~3',
				'driving_license_id'=>'c3~3'
			]
			);
		// $form->setLayout(['view/form/profile']);

		$img_field_array = ['image_id'];

		$field_to_update = [];
		foreach ($pro_fields as $key => $field_name) {

			if($distributor[$field_name] && !in_array($field_name, $img_field_array)){
				$form->layout->add('View',null,$field_name)->set($distributor[$field_name]);
			}else{
				$field_to_update[] = $field_name;
			}
		}
		if(count($field_to_update))
			$form->setModel($distributor,$field_to_update);

		$attachment = $this->add('xavoc\mlm\Model_Attachment');
		$attachment->addCondition('distributor_id',$distributor->id);
		$attachment->tryLoadAny();

		$update_attachment = ['pan_card_id'=>'pan_card_id','aadhar_card_id'=>'aadhar_card_id','driving_license_id'=>'driving_license_id'];

		if($attachment->loaded()){
			if($attachment['pan_card_id']){
				$form->layout->add('View',null,'pan_card_id')->setHtml('<a target="_blank" href="'.$attachment['pan_card'].'"><img style="width:100%;" src="'.$attachment['pan_card'].'"/></a>');
				unset($update_attachment['pan_card_id']);
			}else{
				$field = $form->addField('xepan\base\Upload','pan_card_id');
				$field->setModel('xepan\filestore\Image');
			}

			if($attachment['aadhar_card_id']){
				$form->layout->add('View',null,'aadhar_card_id')->setHtml('<a target="_blank" href="'.$attachment['aadhar_card'].'"><img style="width:100%;" src="'.$attachment['aadhar_card'].'"/></a>');				
				unset($update_attachment['aadhar_card_id']);
			}else{
				$field = $form->addField('xepan\base\Upload','aadhar_card_id');
				$field->setModel('xepan\filestore\Image');
			}

			if($attachment['driving_license_id']){
				$form->layout->add('View',null,'driving_license_id')->setHtml('<a target="_blank" href="'.$attachment['driving_license'].'"><img style="width:100%;" src="'.$attachment['driving_license'].'"/></a>');
				unset($update_attachment['driving_license_id']);
			}else{
				$field = $form->addField('xepan\base\Upload','driving_license_id');
				$field->setModel('xepan\filestore\Image');
			}
		}
		// attachment field
		// $form->getElement('dob')->setAttr('disabled',true);
		// $img_view = $form->add('View')->setHtml('<img src="'.$distributor['image'].'"/>');
		// $img_field= $form->getElement('image_id');
		// $img_field->js('change',$img_view->js()->reload());

		// $country_field = $form->getElement('country_id');
		// $country_field->validate('required');
		
		// $state_field = $form->getElement('state_id');
		// $state_field->validate('required');
		// $form->getElement('city')->validate('required');
		// $form->getElement('address')->validate('required');
		// $form->getElement('pin_code')->validate('required');

		// if($_GET['country_id']){
		// 	$state_field->getModel()->addCondition('country_id',$_GET['country_id']);
		// }
		// $country_field->js('change',$state_field->js()->reload(null,null,[$this->app->url(null,['cut_object'=>$state_field->name]),'country_id'=>$country_field->js()->val()]));
		// $country_field->js('change',$form->js()->atk4_form('reloadField','state_id',[$this->app->url(null,['cut_object'=>$state_field->name]),'country_id'=>$country_field->js()->val()]));

		if(count($field_to_update) > 0 OR count($update_attachment) > 0){
			$form->addSubmit('Update')->addClass('btn btn-primary');

			if($form->isSubmitted()){
				if($distributor->isRoot()) $this->app->skip_sponsor_introducer_mandatory = true;
				$dis = $this->add('xavoc\mlm\Model_Distributor')->load($distributor->id);
				
				foreach ($field_to_update as $key => $field_name) {
					$dis[$field_name] = $form[$field_name];
				}
				$dis->save();

				// update attachment 
				if(count($update_attachment)){
					foreach ($update_attachment as $key => $value) {
						$attachment[$key] = $form[$key];
					}
					$attachment->save();
				}

				$this->app->skip_sponsor_introducer_mandatory = false;
				$js_event = [
					$form->js()->reload(),
					$form->js(true)->_selector('img.ds-dp')->attr('src',$dis['image'])
				];
				$form->js(null,$js_event)->univ()->successMessage('saved')->execute();
			
			}
			
		}


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
				$this->distributor['password'] = $change_pass_form['new_password'];
				$this->distributor->save();

				$this->app->auth->logout();
				$this->app->redirect($this->options['login_page']);
				// $change_pass_form->js()->univ()->successMessage('Password Changed Successfully')->execute();
			}
			$change_pass_form->js()->univ()->errorMessage('some thing happen wrong')->execute();
		}
		// end ---------------
	}
}