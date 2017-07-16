<?php

namespace xavoc\mlm;

class page_setdate extends \xepan\base\Page {
	function init(){
		parent::init();

		if($_GET['clear']){
			$this->app->forget('current_date');
			$this->app->redirect($this->app->url());
		}

		$form=$this->add('Form');
		$form->addField('DateTimePicker','date')->set($this->api->now)->validateNotNull();
		$form->addSubmit('Change');

		if($form->isSubmitted()){
			$this->api->setDate($form['date']);
			$this->js()->redirect()->execute();
		}

		$btn = $this->add('Button')->set("Clear");
		$btn->js('click',$this->js()->reload(['clear'=>true]));

		

	}
}