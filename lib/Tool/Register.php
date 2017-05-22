<?php

namespace xavoc\mlm;


/**
* 
*/
class Tool_Register extends \xepan\cms\View_Tool{
	
	public $options = [
				'show_caption'=>true
			];
	
	function init(){
		parent::init();

		$form = $this->add('Form');
		$form->setModel('xavoc\mlm\Distributor',['first_name','last_name','sponsor_id','side','introducer_id']);
		// $form->addField('xepan\base\DropDownNormal','sponsor')->setModel('xavoc\mlm\Distributor');
		// $form->addField('xepan\base\DropDownNormal','introducer')->setModel('xavoc\mlm\Distributor');
		$form->addSubmit('Register');
		
		if($form->isSubmitted()){
			$distributor = $this->add('xavoc\mlm\Model_Distributor');
			$distributor->register($form->get());			
			$form->js()->univ()->errorMessage('asd')->execute();
		}
	}
}