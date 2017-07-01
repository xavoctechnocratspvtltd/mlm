<?php

namespace xavoc\mlm;

class Tool_FranchisesMenu extends \xepan\cms\View_Tool{
	public $options = ['login_page'=>'login'];

	function init(){
		parent::init();

		if($this->owner instanceof \AbstractController) return;
		
		// $this->distributor = $distributor = $this->add('xavoc\mlm\Model_Distributor');
		// $distributor->addExpression('attachment_count')->set(function($m,$q){
		// 	return $q->expr('IFNULL([0],0)',[$m->refSQL('xavoc\mlm\Attachment')->count()]);
		// });
		$franchises = $this->app->auth->model;
		// $distributor->loadLoggedIn();
		// if(!$distributor->loaded()){
		// 	return "distributor not found";
		// }

		$menu = [
				['key'=>'franchises_dashboard','name'=>'Dashboard'],
				['key'=>'franchises_order','name'=>'New Orders'],
				['key'=>'franchises_verifyorder','name'=>'Verify Orders'],
				['key'=>'franchises_setting','name'=>'Settings'],
			];

		$this->complete_lister = $cl = $this->add('CompleteLister',null,null,['view/franchisesmenu']);
		$cl->setSource($menu);
		$page = $this->app->page;	
		$cl->addHook('formatRow',function($g)use($page){
			if($g->model['key'] == $page)
				$g->current_row_html['active_menu'] = "active";
			else
				$g->current_row_html['active_menu'] = "deactive";
		});

		$cl->template->trySet('franchises_name',$franchises['username']);
		$cl->template->trySet('franchises_dp',($franchises['image']?:"shared/apps/xavoc/mlm/templates/img/profile.png"));

	}
}