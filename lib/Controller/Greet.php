<?php


namespace xavoc\mlm;


class Controlelr_Greet extends \AbstractController {

	function do($distributor,$event,$related_document=null){
		$messages_model = $this->add('xepan\base\Model_ConfigJsonModel',
			[
				'fields'=>[
							'welcome_mail_subject'=>'Line',
							'welcome_mail_content'=>'xepan\base\RichText',
							'welcome_sms_content'=>'Text',
							// 'green_mail_subject'=>'Line',
							// 'green_mail_content'=>'xepan\base\RichText',
							// 'green_sms_content'=>'Text',
							'deactivate_mail_subject'=>'Line',
							'deactivate_mail_content'=>'xepan\base\RichText',
							'deactivate_sms_content'=>'Text',
							'payout_mail_subject'=>'Line',
							'payout_mail_content'=>'xepan\base\RichText',
							'payout_sms_content'=>'Text',
							'topup_mail_subject'=>'Line',
							'topup_mail_content'=>'xepan\base\RichText',
							'topup_sms_content'=>'Text',
							'repurchase_mail_subject'=>'Line',
							'repurchase_mail_content'=>'xepan\base\RichText',
							'repurchase_sms_content'=>'Text'
						],
					'config_key'=>'DM_WELCOME_CONTENT',
					'application'=>'mlm'
			]);
		$messages_model->tryLoadAny();

		if($related_document) 
			$data = array_merge($distributor->data,$related_document->data);
		else
			$data = $distributor->data;

		if($this->app->getConfig('send_email',false)){

			if($messages_model[$event.'_mail_subject'] AND $messages_model[$event.'_mail_content']){

				$temp = $this->add('GiTemplate');
				$temp->loadTemplateFromString($messages_model[$event.'_mail_subject']);

				$temp->set($data);
				$subject = $temp->render();
					// body
				$temp = $this->add('GiTemplate');
				$temp->loadTemplateFromString($messages_model[$event.'_mail_content']);
				$temp->set($data);
				$body = $temp->render();

				$email_setting = $this->add('xepan\communication\Model_Communication_EmailSetting')->setOrder('id','asc');
				$email_setting->addCondition('is_active',true);
				$email_setting->tryLoadAny();

				if(!$email_setting->loaded()) throw new \Exception("update your email setting ", 1);


				$communication = $this->add('xepan\communication\Model_Communication_Abstract_Email');
				$communication->addCondition('communication_type','Email');

				$communication->getElement('status')->defaultValue('Draft');
				$communication['direction']='Out';
				$communication->setfrom($email_setting['from_email'],$email_setting['from_name']);
				
				$communication->addTo($distributor['email']);
				$communication->setSubject($subject);
				$communication->setBody($body);
				$communication->send($email_setting);
			}
		}

		if($this->app->getConfig('send_sms',false)){
			$message = $messages_model[$event.'_sms_content'];
			$temp = $this->add('GiTemplate');
			$temp->loadTemplateFromString($message);
			$temp->set($data);
			$message = $temp->render();
			
			if($messages_model[$event.'_sms_content']){
				$this->add('xepan\communication\Controller_Sms')->sendMessage($distributor['mobile_number'],$message);
			}
		}
	}
}