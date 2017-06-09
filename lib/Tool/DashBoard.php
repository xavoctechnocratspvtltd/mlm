<?php

namespace xavoc\mlm;

/**
* 
*/
class Tool_DashBoard extends \xepan\cms\View_Tool{
	public $options = [
				'show-status'=>null,
				'login_page'=>'login'
			];
	
	function init(){
		parent::init();

		if($this->options['show-status']){
		}

		$this->distributor = $distributor = $this->add('xavoc\mlm\Model_Distributor');
		$distributor->loadLoggedIn();
		if(!$distributor->loaded()){
			$this->add('View')->set('Distributor login Required');
			$this->add('Button')->set('click to login')->js('click')->univ()->redirect($this->app->url($this->options['login_page']));
			// $this->app->redirect($this->app->url($this->options['login_page']));
			return;
		}

		$this->add('xavoc\mlm\View_ProfileChecker');
	}
}