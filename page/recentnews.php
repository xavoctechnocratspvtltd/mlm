<?php


namespace xavoc\mlm;

class page_recentnews extends \xepan\base\Page {
	public $title= "Recent News";

	function init(){
		parent::init();

		// welcome mail and sms
		$config_model = $this->add('xepan\base\Model_ConfigJsonModel',
			[
				'fields'=>[
							'recent_news'=>'xepan\base\RichText',
						],
					'config_key'=>'DM_RECENTNEWS',
					'application'=>'mlm'
			]);
		$config_model->tryLoadAny();

		$form = $this->add('Form');
		$form->setModel($config_model);
		$form->addSubmit('save');
		if($form->isSubmitted()){
			$form->save();
			$form->js()->univ()->successMessage('saved successfully')->execute();
		}

	}
}