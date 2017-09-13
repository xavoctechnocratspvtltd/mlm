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

		// profile
		$col = $profile_tab->add('Columns');
		$pro_fields = ['introducer','side','first_name','last_name','dob','email','mobile_number','pan_no','country_id','country','state_id','state','city','address','pin_code','image_id','nominee_name','relation_with_nominee','nominee_mobile_number','aadhar_card_number','d_account_number','d_bank_name','d_bank_ifsc_code','d_account_type','d_bank_branch'];
		$form = $col->add('Form');
		$form->add('xepan\base\Controller_FLC')
		->addContentSpot()
		->layout([
				'introducer~Introducer'=>'PLACEMENT DETAILS~c1~6',
				'side~Placement Side'=>'c2~6',
				'first_name'=>'PERSONAL DETAILS~c1~4',
				'last_name'=>'c2~4',
				'dob~Date Of Birth'=>'c3~4',
				'country_id~Country'=>'c8~4',
				'country~'=>'c8~4',
				'state_id~State'=>'c9~4',
				'state~'=>'c9~4',
				'city'=>'c10~2',
				'pin_code'=>'c11~2',
				'address'=>'c12~12',
				'email'=>'c4~4',
				'mobile_number'=>'c5~4',
				'aadhar_card_number'=>'c6~4',
				'nominee_name'=>'NOMINEE DETAILS~c1~4',
				'relation_with_nominee'=>'c2~4',
				'nominee_mobile_number'=>'c3~4',
				'd_bank_name~Bank Name'=>'BANK DETAILS~c1~3',
				'd_account_number~Account Number'=>'c2~3',
				'd_bank_ifsc_code~Bank IFSC Code'=>'c3~3',
				'd_account_type~Account Type'=>'c4~3',
				'd_bank_branch~Branch Name'=>'c1~3',
				'pan_no'=>'c2~3',
				'cancelled_cheque'=>'c31~12',
				'image_id~Profile Image'=>'KYC DETAILS~c41~3',
				'pan_card~PAN Card'=>'c42~3',
				'id_proof~ID Proof'=>'c43~3',
				'address_proof~Address Proof'=>'c44~3'
			]);

		if($distributor['side'] == "A"){
			$distributor['side'] = "Left";
		}else{
			$distributor['side'] = "Right";
		}

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

		if($distributor['image_id']){
			$form->layout->add('View',null,'image_id')
						->setHtml('<a target="_blank" href="'.$distributor['image'].'"><img style="width:100%;" src="'.$distributor['image'].'"/></a>');
		}else{
			$form->getElement('image_id')
				->allowMultiple(1)
				->setFormatFilesTemplate('view/file_upload')
				;
		}

		$attachment = $this->add('xavoc\mlm\Model_Attachment');
		$attachment->addCondition('distributor_id',$distributor->id);
		$attachment->tryLoadAny();

		$update_attachment = [
							'pan_card'=>'pan_card_id',
							'id_proof'=>'id_proof_id',
							'address_proof'=>'address_proof_id',
							'cancelled_cheque'=>'cancelled_cheque_id'
						];
		foreach ($update_attachment as $key => $value) {

			if($attachment->loaded() && !$attachment[$value]){
				$attachment_field = $form->addField('xepan\base\Upload',$key)
						->allowMultiple(1)
						->setFormatFilesTemplate('view/file_upload');
				$attachment_field->setModel('xepan\filestore\Image');
			}else{
				$form->layout->add('View',null,$key)
						->setHtml('<a target="_blank" href="'.$attachment[$key].'"><img style="width:100%;" src="'.$attachment[$key].'"/></a>');
				unset($update_attachment[$key]);
			}
		}
		
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
						$attachment[$value] = $form[$key];
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