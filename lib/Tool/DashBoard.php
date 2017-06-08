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
			$this->app->redirect($this->app->url($this->options['login_page']));
		}

		$this->add('xavoc\mlm\View_ProfileChecker');
		$this->add('View_Info')->set('Dashboard Tool');
	}
}