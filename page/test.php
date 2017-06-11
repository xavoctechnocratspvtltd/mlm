<?php


namespace xavoc\mlm;

class page_test extends \xepan\base\Page {
	public $title= "Test Page";

	function init(){
		parent::init();

		$form = $this->add('Form');
		$form->addField('mobile_no');
		$form->addField('text','msg');
		$form->addSubmit('Submit');

		$v = $this->add('View')->set($_GET['data']);

		if($form->isSubmitted()){			
			$data = $this->add('xepan\communication\Controller_Sms')->sendMessage($form['mobile_no'],$form['msg']);
			$form->js(null,$v->js()->reload(['data'=>$data]))->univ()->successMessage("send ")->execute();
		}

	}
}