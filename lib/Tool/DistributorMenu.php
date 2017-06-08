<?php

namespace xavoc\mlm;

class Tool_DistributorMenu extends \xepan\cms\View_Tool{ 
	public $options = ['login_page'=>'login'];

	function init(){
		parent::init();

		$menu = [
				['key'=>'dashboard','name'=>'Dashboard'],
				['key'=>'panelregistration', 'name'=>'Registration'],
				['key'=>'genology','name'=>'Genology'],
				['key'=>'mypayouts','name'=>'My Payouts'],
				['key'=>'mywallet','name'=>'My Wallet']
			];

		$this->complete_lister = $cl = $this->add('CompleteLister',null,null,['view/distributormenu']);
		$cl->setSource($menu);
		$page = $this->app->page;	
		$cl->addHook('formatRow',function($g)use($page){
			if($g->model['key'] == $page)
				$g->current_row_html['active_menu'] = "active";
			else
				$g->current_row_html['active_menu'] = "deactive";
		});

		
	}
}