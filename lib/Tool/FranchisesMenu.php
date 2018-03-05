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
				// ['key'=>'franchises_order','name'=>'New Orders'],
				['key'=>'franchises_verifyorder','name'=>'Manage Order'],
				// ['key'=>'franchises_dispatch','name'=>'Dispatch Request '.$assign_order_count],
				['key'=>'franchises_stock','name'=>'Report'],
				['key'=>'franchises_setting','name'=>'Settings'],
			];
		$submenu_list = [
					'franchises_stock'=>[
								'index.php?page=franchises_stock&report=itemstock'=>'Total Stock',
								'index.php?page=franchises_stock&report=stocktransaction'=>'Stock Transaction',
								'index.php?page=franchises_stock&report=salereport'=>'Sale Report'
								],
					'franchises_verifyorder'=>[
							'index.php?page=franchises_verifyorder&action=verify'=>'Verify Order',
							'index.php?page=franchises_verifyorder&action=history'=>'Order History',
						]
					];

		$this->complete_lister = $cl = $this->add('CompleteLister',null,null,['view/franchisesmenu']);
		$cl->setSource($menu);
		$page = $this->app->page;	
		$cl->addHook('formatRow',function($g)use($page,$submenu_list){
			$submenu_html = "";
			$submenu_class = "";

			if(isset($submenu_list[$g->model['key']])){
				$submenu_html = '<ul class="dropdown-menu">';
				foreach ($submenu_list[$g->model['key']] as $s_key => $s_value) {
					$submenu_html .= '<li><a class="dropdown-item" href="'.$s_key.'">'.$s_value.'</a></li>';
				}
				$submenu_html .= '</ul>';
				$submenu_class = "dropdown";

				$g->current_row_html['list'] = '<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">'.$g->model['name'].' <span class="caret"></span></a>';
			}else{
				$g->current_row_html['list'] = '<a href="'.$g->model['key'].'">'.$g->model['name'].'</a>';
			}

			if($g->model['key'] == $page)
				$g->current_row_html['active_menu'] = "active ".$submenu_class;
			else
				$g->current_row_html['active_menu'] = "deactive ".$submenu_class;
			
			$g->current_row_html['submenu'] = $submenu_html;
		});


		$cl->template->trySet('franchises_name',$this->app->auth->model['username']);
		$cl->template->trySet('franchises_dp',($franchises['image']?:"shared/apps/xavoc/mlm/templates/img/profile.png"));

		$this->js(true)->_selector('.dropdown-toggle')->dropdown();
	}
}