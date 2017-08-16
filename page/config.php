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
							'topup_sms_content'=>'Text'
						],
					'config_key'=>'DM_WELCOME_CONTENT',
					'application'=>'mlm'
			]);
		$welcome_model->tryLoadAny();

		$w_tab = $tab->addTab('Mail & SMS Layout');

		$tab = $w_tab->add('Tabs');
		$welcome_tab = $tab->addTab('Red/ Registartion SMS/Email');

		$f = $welcome_tab->add('Form');
		$f->setModel($welcome_model,['welcome_mail_subject','welcome_mail_content','welcome_sms_content']);
		$f->addSubmit('Update');
		if($f->isSubmitted()){
			$f->save();
			$f->js()->reload()->univ()->successMessage('Saved Successfully')->execute();
		}

		$green_tab = $tab->addTab('Green/Activation SMS/Email');
		$f = $green_tab->add('Form');
		$f->setModel($welcome_model,['green_mail_subject','green_mail_content','green_sms_content']);
		$f->addSubmit('Update');
		if($f->isSubmitted()){
			$f->save();
			$f->js()->reload()->univ()->successMessage('Saved Successfully')->execute();
		}

		$d_tab = $tab->addTab('Deactivate Email/SMS');
		$f = $d_tab->add('Form');
		$f->setModel($welcome_model,['deactivate_mail_subject','deactivate_mail_content','deactivate_sms_content']);
		$f->addSubmit('Update');
		if($f->isSubmitted()){
			$f->save();
			$f->js()->reload()->univ()->successMessage('Saved Successfully')->execute();
		}

		$p_tab = $tab->addTab('Payout Email/SMS');
		$f = $p_tab->add('Form');
		$f->setModel($welcome_model,['payout_mail_subject','payout_mail_content','payout_sms_content']);
		$f->addSubmit('Update');
		if($f->isSubmitted()){
			$f->save();
			$f->js()->reload()->univ()->successMessage('Saved Successfully')->execute();
		}

		$t_tab = $tab->addTab('Topup Email/SMS');
		$f = $t_tab->add('Form');
		$f->setModel($welcome_model,['topup_mail_subject','topup_mail_content','topup_sms_content']);
		$f->addSubmit('Update');
		if($f->isSubmitted()){
			$f->save();
			$f->js()->reload()->univ()->successMessage('Saved Successfully')->execute();
		}

	}
}