<?php

namespace xavoc\mlm;

/**
* 
*/
class page_config extends \xepan\base\Page{

	public $title = "MLM Configuration";
	
	function init(){
		parent::init();

		$tab = $this->add('Tabs');
		
		$g_tab = $tab->addTab('Generation Income Slab');
		$g_crud = $g_tab->add('xepan\hr\Grid');
		$g_crud->setModel('xavoc\mlm\GenerationIncomeSlab');
		
		$r_tab = $tab->addTab('RePurchase Bonus Slab');
		$r_crud = $r_tab->add('xepan\hr\Grid');
		$r_crud->setModel('xavoc\mlm\RePurchaseBonusSlab');

		// welcome mail and sms
		$welcome_model = $this->add('xepan\base\Model_ConfigJsonModel',
			[
				'fields'=>[
							'welcome_mail_subject'=>'Line',
							'welcome_mail_content'=>'xepan\base\RichText',
							'welcome_sms_content'=>'Text',
							'green_mail_subject'=>'Line',
							'green_mail_content'=>'xepan\base\RichText',
							'green_sms_content'=>'Text',
							'deactivate_mail_subject'=>'Line',
							'deactivate_mail_content'=>'xepan\base\RichText',
							'deactivate_sms_content'=>'Text',
							'payout_mail_subject'=>'Line',
							'payout_mail_content'=>'xepan\base\RichText',
							'payout_sms_content'=>'Text',
							'topup_mail_subject'=>'Line',
							'topup_mail_content'=>'xepan\base\RichText',
							'topup_sms_content'=>'Text',
						],
					'config_key'=>'DM_WELCOME_CONTENT',
					'application'=>'mlm'
			]);
		$welcome_model->tryLoadAny();
		$w_tab = $tab->addTab('Mail & SMS Layout');
		// $form = $w_tab->add('Form');
		// $form->setModel($welcome_model);
		// $form->addSubmit('Save');
		// if($form->isSubmitted()){
		// 	$form->update();
		// 	$form->js(null,$form->js()->reload())->univ()->successMessage('Saved')->execute();
		// }

		$f = $w_tab->add('Form');
		$f->addField('line','welcome_mail_subject')->set($welcome_model['welcome_mail_subject']);
		$f->addField('xepan\base\RichText','welcome_mail_content')->set($welcome_model['welcome_mail_content']);
		$f->addField('text','welcome_sms_content')->set($welcome_model['welcome_sms_content']);

		$f->addField('line','green_mail_subject')->set($welcome_model['green_mail_subject']);
		$f->addField('xepan\base\RichText','green_mail_content')->set($welcome_model['green_mail_content']);
		$f->addField('text','green_sms_content')->set($welcome_model['welcome_sms_content']);

		$f->addField('line','deactivate_mail_subject')->set($welcome_model['deactivate_mail_subject']);
		$f->addField('xepan\base\RichText','deactivate_mail_content')->set($welcome_model['deactivate_mail_subject']);
		$f->addField('text','deactivate_sms_content')->set($welcome_model['deactivate_sms_content']);

		$f->addField('line','payout_mail_subject')->set($welcome_model['payout_mail_subject']);
		$f->addField('xepan\base\RichText','payout_mail_content')->set($welcome_model['payout_mail_content']);
		$f->addField('text','payout_sms_content')->set($welcome_model['payout_sms_content']);

		$f->addField('line','topup_mail_subject')->set($welcome_model['topup_mail_subject']);
		$f->addField('xepan\base\RichText','topup_mail_content')->set($welcome_model['topup_mail_content']);
		$f->addField('text','topup_sms_content')->set($welcome_model['topup_sms_content']);
		$f->addSubmit('Update')->addClass('btn btn-primary');
		if($f->isSubmitted()){

			$welcome_model['welcome_mail_subject'] = $f['welcome_mail_subject'];	
			$welcome_model['welcome_mail_content'] = $f['welcome_mail_content'];	
			$welcome_model['welcome_sms_content'] = $f['welcome_sms_content'];	
			$welcome_model['green_mail_subject'] = $f['green_mail_subject'];	
			$welcome_model['green_mail_content'] = $f['green_mail_content'];	
			$welcome_model['green_sms_content'] = $f['green_sms_content'];
			$welcome_model['deactivate_mail_subject'] = $f['deactivate_mail_subject'];
			$welcome_model['deactivate_mail_content'] = $f['deactivate_mail_content'];
			$welcome_model['deactivate_sms_content'] = $f['deactivate_sms_content'];
			$welcome_model['payout_mail_subject'] = $f['payout_mail_subject'];
			$welcome_model['payout_mail_content'] = $f['payout_mail_content'];
			$welcome_model['payout_sms_content'] = $f['payout_sms_content'];
			$welcome_model['topup_mail_subject'] = $f['topup_mail_subject'];
			$welcome_model['topup_mail_content'] = $f['topup_mail_content'];
			$welcome_model['topup_sms_content'] = $f['topup_sms_content'];

			$welcome_model->save();	

			$f->js(null,$f->js()->reload())->univ()->successMessage('Saved')->execute();
		}
	}
}