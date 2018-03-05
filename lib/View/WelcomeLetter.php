<?php

namespace xavoc\mlm;
class View_WelcomeLetter extends \View{

	function init(){
		parent::init();

		$distributor = $this->add('xavoc\mlm\Model_Distributor');
		$distributor->loadLoggedIn();
		if(!$distributor->loaded()){
			$this->add('View')->addClass('alert alert-danger')->set();
		}

		if(!$_GET['cut_page']){
			$button = $this->add('Button')->set('Click to Print Welcome Letter');
			$button->js('click')->univ()->newWindow($this->app->url(null,['cut_page'=>1]));
		}else{
			$view = $this->add('View',null,null,['xavoc\view\welcomeletter']);
			$view->setModel($distributor);
		}

	}
}