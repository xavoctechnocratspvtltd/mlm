<?php

namespace xavoc\mlm;

class Tool_FranchisesMenu extends \xepan\cms\View_Tool{
	public $options = ['login_page'=>'login'];

	function init(){
		parent::init();

		if($this->owner instanceof \AbstractController) return;
		
		$this->franchises = $franchises = $this->add('xavoc\mlm\Model_Franchises');
		$franchises->loadLoggedIn();
		$editor_user = $this->add('xepan\cms\Model_User_CMSEditor');
		$editor_user->addCondition('user_id',$this->app->auth->model->id);
		$editor_user->tryLoadAny();
		
		if(!$franchises->loaded() AND !$editor_user->loaded()){
			$this->app->redirect('login');
		}

		$assign_order = $this->add('xavoc\mlm\Model_AssignOrder');
		$assign_order->addCondition('franchises_id',$franchises->id);
		$assign_order->addCondition('status','<>','Completed');
		$assign_order_count = "" ;
		if($assign_order->count()->getOne() > 0)
			$assign_order_count = '<span class="badge">'.$assign_order->count()->getOne()."</span>";
		

		$menu = [
				['key'=>'franchises_dashboard','name'=>'Dashboard'],
				['key'=>'franchises_order','name'=>'New Orders'],
				['key'=>'franchises_verifyorder','name'=>'Verify Orders'],
				['key'=>'franchises_dispatch','name'=>'Dispatch Request '.$assign_order_count],
				['key'=>'franchises_stock','name'=>'Stock'],
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
			
			$g->current_row_html['name'] = $g->model['name'];
		});


		$cl->template->trySet('franchises_name',$this->app->auth->model['username']);
		$cl->template->trySet('franchises_dp',($franchises['image']?:"shared/apps/xavoc/mlm/templates/img/profile.png"));

	}
}