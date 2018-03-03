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
							'repurchase_sms_content'=>'Text',
							'dispatch_mail_subject'=>'Line',
							'dispatch_mail_content'=>'xepan\base\RichText',
							'dispatch_sms_content'=>'Text',
							'rank_update_sms_content'=>'Text',

							'franchises_activate_mail_subject'=>'Line',
							'franchises_activate_mail_content'=>'xepan\base\RichText',
							'franchises_activate_sms_content'=>'Text'

						],
					'config_key'=>'DM_WELCOME_CONTENT',
					'application'=>'mlm'
			]);
		$welcome_model->tryLoadAny();

		$w_tab = $tab->addTab('Mail & SMS Layout');

		// closing related conig
		$ctab = $tab->addTab('ClosingRelatedConfig');
		$c_s_m = $this->add('xepan\base\Model_ConfigJsonModel',
				[
					'fields'=>[
								'mark_green_stopped'=>'checkbox',
								'enable_closing'=>'checkbox',
								'new_registration_stopped'=>'checkbox',
								'auto_daily_closing'=>'checkbox',
								'weekly_closing_day'=>'DropDown',
								'monthly_closing_date'=>'DropDown',
							],
						'config_key'=>'CLOSING_RELATED_CONFIG',
						'application'=>'mlm'
				]);
		$c_s_m->tryLoadAny();
		
		$form = $ctab->add('Form');
		$form->setModel($c_s_m);
		$day_field = $form->getElement('weekly_closing_day');
		$day_field->setValueList([
					"0"=>"Sunday",
					"1"=>"Monday",
					"2"=>"Tuesday",
					"3"=>"Wednesday",
					"4"=>"Thursday",
					"5"=>"Friday",
					"6"=>"Saturday"
				]);
		$date_field = $form->getElement('monthly_closing_date');
		$date_field->setValueList([
				'01'=>'01','02'=>'02','03'=>'03','04'=>'04','05'=>'05','06'=>'06','07'=>'07','08'=>'08','09'=>'09','10'=>'10',
				'11'=>'11','12'=>'12','13'=>'13','14'=>'14','15'=>'15','16'=>'16','17'=>'17','18'=>'18','19'=>'19','20'=>'20',
				'21'=>'21','22'=>'22','23'=>'23','24'=>'24','25'=>'25','26'=>'26','27'=>'27','28'=>'28','29'=>'29','30'=>'30','31'=>'31'
			]);

		$form->addSubmit('Update');
		if($form->isSubmitted()){
			$form->save();
			$form->js(null,$form->js()->reload())->univ()->successMessage('closing config updated')->execute();
		}
		//------------------

		$tab = $w_tab->add('Tabs');
		$welcome_tab = $tab->addTab('Red/ Registartion SMS/Email');

		$f = $welcome_tab->add('Form');
		$f->setModel($welcome_model,['welcome_mail_subject','welcome_mail_content','welcome_sms_content']);
		$f->addSubmit('Update');
		if($f->isSubmitted()){
			$f->save();
			$f->js()->reload()->univ()->successMessage('Saved Successfully')->execute();
		}

		$green_tab = $tab->addTab('Topup/Re-topup SMS/Email');
		$f = $green_tab->add('Form');
		$f->setModel($welcome_model,['topup_mail_subject','topup_mail_content','topup_sms_content']);
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

		// $t_tab = $tab->addTab('Topup Email/SMS');
		// $f = $t_tab->add('Form');
		// $f->setModel($welcome_model,['topup_mail_subject','topup_mail_content','topup_sms_content']);
		// $f->addSubmit('Update');
		// if($f->isSubmitted()){
		// 	$f->save();
		// 	$f->js()->reload()->univ()->successMessage('Saved Successfully')->execute();
		// }

		$r_tab = $tab->addTab('Repurchase Email/SMS');
		$f = $r_tab->add('Form');
		$f->setModel($welcome_model,['repurchase_mail_subject','repurchase_mail_content','repurchase_sms_content']);
		$f->addSubmit('Update');
		if($f->isSubmitted()){
			$f->save();
			$f->js()->reload()->univ()->successMessage('Saved Successfully')->execute();
		}

		$r_tab = $tab->addTab('Dispatch Email/SMS');
		$f = $r_tab->add('Form');
		$f->setModel($welcome_model,['dispatch_mail_subject','dispatch_mail_content','dispatch_sms_content']);
		$f->addSubmit('Update');
		if($f->isSubmitted()){
			$f->save();
			$f->js()->reload()->univ()->successMessage('Saved Successfully')->execute();
		}

		$r_tab = $tab->addTab('Rank Change SMS');
		$f = $r_tab->add('Form');
		$f->setModel($welcome_model,['rank_update_sms_content']);
		$f->addSubmit('Update');
		if($f->isSubmitted()){
			$f->save();
			$f->js()->reload()->univ()->successMessage('Saved Successfully')->execute();
		}


		// franchises
		$tab = $tab->addTab('Franchises Activate Mail Content');
		$f = $tab->add('Form');
		$f->setModel($welcome_model,['franchises_activate_mail_subject','franchises_activate_mail_content','franchises_activate_sms_content']);
		$f->addSubmit('Update');
		if($f->isSubmitted()){
			$f->save();
			$f->js()->reload()->univ()->successMessage('Saved Successfully')->execute();
		}


	}
}