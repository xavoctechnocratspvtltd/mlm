<?php

namespace xavoc\mlm;

class View_DistributorNotFound extends \View{

	function init(){
		parent::init();

		$this->add('Button')->set('Distributor Login')->js('click')->univ()->redirect($this->app->url('login'));
	}
};