<?php

namespace xavoc\mlm;

class View_Card extends \View{

	public $options= [
						'header'=>'header test',
						'title'=>'Title',
						'icon'=>'glyphicon glyphicon-user',
						'theme'=>'orange', //red, green, blur, red, purple
						'footer'=>''
					];

	function init(){
		parent::init();

	}

	function render(){
		$this->template->trySetHtml('header',$this->options['header']?:"Heading");
		$this->template->trySetHtml('title',$this->options['title']?:0);
		$this->template->trySetHtml('icon',$this->options['icon']?:"glyphicon glyphicon-user");
		$theme_class = "card-".$this->options['theme'];

		$this->template->trySetHtml('theme_class',$theme_class);

		parent::render();
	}

	function defaultTemplate(){
		return ['view/card'];
	}
};