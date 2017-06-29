<?php

namespace xavoc\mlm;

class Tool_DistributorMenu extends \xavoc\mlm\Tool_Distributor{ 
	public $options = ['login_page'=>'login'];

	function init(){
		parent::init();
		if($this->owner instanceof \AbstractController) return;

		$this->distributor = $distributor = $this->add('xavoc\mlm\Model_Distributor');
		$distributor->addExpression('attachment_count')->set(function($m,$q){
			return $q->expr('IFNULL([0],0)',[$m->refSQL('xavoc\mlm\Attachment')->count()]);
		});

		$distributor->loadLoggedIn();
		if(!$distributor->loaded()){
			return;
		}

		$menu = [
				['key'=>'dashboard','name'=>'Dashboard'],
				['key'=>'panelregistration', 'name'=>'Registration'],
				['key'=>'genology','name'=>'Genology'],
				['key'=>'generation','name'=>'Generation'],
				['key'=>'repurchase','name'=>'Repurchase'],
				['key'=>'mypayouts','name'=>'My Payouts'],
				// ['key'=>'mywallet','name'=>'My Wallet'],
				['key'=>'myorder','name'=>'My Orders'],
				['key'=>'setting','name'=>'Settings'],
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

		$cl->template->trySet('distributor_name',$distributor['name']);
		$cl->template->trySet('distributor_dp',($distributor['image']?:"shared/apps/xavoc/mlm/templates/img/profile.png"));

		$cl->template->trySet('distributor_name',$distributor['name']);
		$cl->template->trySet('user_name',$this->app->auth->model['username']);
	}
}