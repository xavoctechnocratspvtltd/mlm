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

		$this->addClass('mlm-member-panel-registration');		
		$this->app->stickyGET('new_dist_id');

		$v = $this->add('View');

		if($_GET['new_dist_id']){
			$new_dis = $this->add('xavoc\mlm\Model_Distributor')->load($_GET['new_dist_id']);
			$v->add('View')->addClass('alert alert-success text-center')->setHtml('<h4>Registration done successfully. User Id:<strong>'.$new_dis['user']."</strong>, Password: <strong>".$new_dis['password']."</strong></h4>");
		}

		$form_field = ['introducer_id','side','first_name','dob','country_id','state_id','city','pin_code','address','email','mobile_number','pan_no','d_account_number','d_bank_name','d_bank_ifsc_code','nominee_name','relation_with_nominee','nominee_mobile_number','aadhar_card_number','d_account_type','d_bank_branch','image_id'];
		$form = $this->add('Form');
		$form->add('xepan\base\Controller_FLC')
		->addContentSpot()
		->layout([
				'introducer~Search Introducer'=>'PLACEMENT DETAILS~c1~6',
				'side~Placement Side&nbsp;<i class="fa fa-cog color-red"></i>'=>'c2~6',
				'first_name~Full Name&nbsp;<i class="fa fa-cog color-red"></i>'=>'PERSONAL DETAILS~c1~8',
				// 'last_name'=>'c2~4',
				'dob~Date Of Birth'=>'c3~4',
				'country_id~Country&nbsp;<i class="fa fa-cog color-red"></i>'=>'c8~4',
				'state_id~State&nbsp;<i class="fa fa-cog color-red"></i>'=>'c9~4',
				'city~City&nbsp;<i class="fa fa-cog color-red"></i>'=>'c10~2',
				'pin_code~Pin Code&nbsp;<i class="fa fa-cog color-red"></i>'=>'c11~2',
				'address~Address&nbsp;<i class="fa fa-cog color-red"></i>'=>'c12~12',
				'email~Email&nbsp;<i class="fa fa-cog color-red"></i>'=>'c4~4',
				'mobile_number~Mobile Number&nbsp;<i class="fa fa-cog color-red"></i>'=>'c5~4',
				'aadhar_card_number'=>'c6~4',
				'nominee_name'=>'NOMINEE DETAILS~c1~4',
				'relation_with_nominee'=>'c2~4',
				'nominee_mobile_number~Nominee Mobile Number&nbsp;<i class="fa fa-cog color-red"></i>'=>'c3~4',
				'd_bank_name~Bank Name'=>'BANK DETAILS~c1~3',
				'd_account_number~Account Number'=>'c2~3',
				'd_bank_ifsc_code~Bank IFSC Code'=>'c3~3',
				'd_account_type~Account Type'=>'c4~3',
				'd_bank_branch~Branch Name&nbsp;<i class="fa fa-cog color-red"></i>'=>'c1~3',
				'pan_no~Pan No'=>'c2~3',
				'cancelled_cheque'=>'c31~12',
				'image_id~Profile Image'=>'KYC DETAILS~c41~3',
				'pan_card~PAN Card'=>'c42~3',
				'id_proof~ID Proof'=>'c43~3',
				'address_proof~Address Proof'=>'c44~3'
			]
			);
		// $form->setLayout(['view/form/registration']);
		$form->setModel('xavoc\mlm\Distributor',$form_field);

		$form->getElement('introducer_id')->other_field->setAttr('placeholder','Please enter at least 3 or more letters.');
		$form->getElement('side')->setEmptyText('Select Placement Side');
		$form->getElement('relation_with_nominee')->setEmptyText('Select Relation');
		$form->getElement('state_id')->setEmptyText('Select State');
		// $form->getElement('dob')->setAttr('placeholder',"DD/MM/YYYY");
		// $form->getElement('pin_code')->validate('required|number');
		$form->getElement('first_name')->setAttr('placeholder','Full Name');

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
		
		// Attachment form Field
		$form->getElement('image_id')
			->allowMultiple(1)
			->setFormatFilesTemplate('view/file_upload')
			;

		$attachment_type = [
							'pan_card'=>'pan_card_id',
							'id_proof'=>'id_proof_id',
							'address_proof'=>'address_proof_id',
							'cancelled_cheque'=>'cancelled_cheque_id'
						];
		foreach ($attachment_type as $key => $value) {
			$attachment_field = $form->addField('xepan\base\Upload',$key)
					->allowMultiple(1)
					->setFormatFilesTemplate('view/file_upload');
			$attachment_field->setModel('xepan\filestore\Image');
		}

		// $form->addField('username')->validate('required');
		// $form->addField('password','password')->validate('required');	
		// $form->addField('password','retype_password')->validate('required');	
		$form->addSubmit('Register')->addClass(' btn btn-primary btn-block')->setStyle('margin-bottom','60px;');
		
		if($form->isSubmitted()){			
			if($form['password'] !== $form['retype_password'])
				$form->displayError('retype_password','Password Not Match');

			try{
				$this->api->db->beginTransaction();

				$distributor = $this->add('xavoc\mlm\Model_Distributor');
				$distributor->register($form->get());
				
				$attachment = $this->add('xavoc\mlm\Model_Attachment')->addCondition('distributor_id',$distributor->id);
				foreach ($attachment_type as $form_field_name => $model_field_name) {
					if($form[$form_field_name])
						$attachment[$model_field_name] = $form[$form_field_name];
				}
				$attachment->save();

				$this->api->db->commit();
				$v->js(null,[$form->js()->reload(),$v->js()->reload(['new_dist_id'=>$distributor->id])])->univ()->successMessage('Registration Successfully')->execute();
			}catch(\Exception $e){
				$this->api->db->rollback();
				$form->js()->univ()->errorMessage($e->getMessage())->execute();
			}

		}

	}
}