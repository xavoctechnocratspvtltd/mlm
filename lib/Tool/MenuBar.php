<?php

namespace xavoc\mlm;


/**
* 
*/
class Tool_MenuBar extends \xepan\cms\View_Tool{

	public $options = [
			'menu_url' =>'index',
			"custom_template"=>'',
			'show_item_count'=>false,
		];

	function init(){
		parent::init();

		if($this->owner instanceof \AbstractController) return;

		if($this->options['custom_template']){
			$path = getcwd()."/websites/".$this->app->current_website_name."/www/view/tool/".$this->options['custom_template'].".html";
			if(!file_exists($path)){
				$this->add('View_Warning')->set('template not found');
				return;	
			}	
		}else
			$this->options['custom_template'] = "menubar";


		$lister = $this->add('xavoc\mlm\View_MenuLister',['options'=>$this->options]);

	}

}