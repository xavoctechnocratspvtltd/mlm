<?php

namespace xavoc\mlm;

class Model_Franchises extends \xepan\commerce\Model_Store_Warehouse {
	public $table_alias =  'mlm_franchise';
	public $status = ['Active','Deactive'];
	public $actions = [
					'Active'=>['view','edit','delete','deactivate','loginCredential'],
					'Deactive'=>['view','edit','delete','activate']
				];
	public $acl_type = "mlm_franchise";
	public $acl=true;
	function init(){
		parent::init();

		$this->getElement('status')->defaultValue('Active');
		$this->getElement('created_by_id')->defaultValue($this->app->auth->model->id);
	}

	function page_loginCredential($page){
		$form = $page->add('Form');

		$user = $page->add('xepan\base\Model_User');
		if($this['user_id'] > 0)
			$user->load($this['user_id']);
		$this->api->auth->addEncryptionHook($user);
		
		$name_field = $form->addField('user_name');
		if($user->loaded())
			$name_field->set($user['username'])->setAttr('disabled',true);

		$form->addField('password','password')->validate('required');
		$form->addField('password','retype_password')->validate('required');
		$form->addSubmit('Update')->addClass('btn btn-primary');

		if($form->isSubmitted()){
			if($form['password'] != $form['retype_password'])
				$form->displayError('password','Password not match');
			
			if(!$user->loaded()){
				$user['username'] = $form['user_name'];
				$user['password'] = $form['password'];
				$user->save();

				$this['user_id'] = $user->id;
				$this->save();
				return $page->js()->univ()->closeDialog();
			}else{
				if($user->updatePassword($form['password'])){
					return $page->js()->univ()->closeDialog();
				}
			}
			return $form->js()->univ()->errorMessage('some thing happen wrong');
		}
	}

	function activate(){
		$this['status'] = "Active";
		$this->save();
	}

	function deactivate(){
		$this['status'] = "Deactive";
		$this->save();
	}

	function paymentReceived($invoice_model,$franchises_id){
		$fp = $this->add('xavoc\mlm\Model_FranchisePayment');
		$fp['sale_invoice_id'] = $invoice_model['id'];
		// $fp['distributor_id'] = $invoice_model['contact_id'];
		$fp['franchise_id'] = $franchises_id;
		$fp['net_amount'] = $invoice_model['net_amount'];
		$fp->save();
	}
} 