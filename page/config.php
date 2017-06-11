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
		$g_crud = $g_tab->add('xepan\hr\CRUD');
		$g_crud->setModel('xavoc\mlm\GenerationIncomeSlab');
		
		$r_tab = $tab->addTab('RePurchase Bonus Slab');
		$r_crud = $r_tab->add('xepan\hr\CRUD');
		$r_crud->setModel('xavoc\mlm\RePurchaseBonusSlab');

		// welcome mail and sms
		$welcome_model = $this->add('xepan\base\Model_ConfigJsonModel',
			[
				'fields'=>[
							'welcome_mail_subject'=>'Line',
							'welcome_mail_content'=>'Text',
							'welcome_sms_content'=>'Text',
							'payout_mail_subject'=>'Line',
							'payout_mail_content'=>'Text',
							'payout_sms_content'=>'Text',
							'topup_mail_subject'=>'Line',
							'topup_mail_content'=>'Text',
							'topup_sms_content'=>'Text',
						],
					'config_key'=>'DM_WELCOME_CONTENT',
					'application'=>'mlm'
			]);
		$welcome_model->tryLoadAny();
		$w_tab = $tab->addTab('Mail & SMS Layout');
		$form = $w_tab->add('Form');
		$form->setModel($welcome_model);
		$form->addSubmit('Save');
		if($form->isSubmitted()){
			$form->update();
			$form->js(null,$form->js()->reload())->univ()->successMessage('Saved')->execute();
		}

	}
}