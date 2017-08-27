<?php


namespace xavoc\mlm;

class page_test extends \xepan\base\Page {
	public $title= "Test Page";

	function init(){
		parent::init();

		$form = $this->add('Form');
		$form->add('xepan\base\Controller_FLC')
		->showlables(true)
		->makePanelsCoppalsible(true)
		->layout([
				'first_name~FN'=>'Name Section~c1~4',
				'nick_name'=>'c2~4',
				'last_name'=>'c3~4',
				'city'=>'Location~c1~4',
				'state'=>'c2~4',
				'country'=>'c3~4',
			]);
		$form->addField('line','first_name')->validate('required');
		$form->addField('line','last_name');
		$form->addField('line','nick_name');
		$form->addField('DropDown','city')->setValueList(['','Udaipur','Jaipur'])->validate('required');
		$form->addField('DropDown','state')->setValueList(['Udaipur','Jaipur']);
		$form->addField('DropDown','country')->setValueList(['Udaipur','Jaipur']);

		$form->addSubmit('GO');

		if($form->isSubmitted()){
			$form->displayError('city','Hellloooo');
		}
	}
}