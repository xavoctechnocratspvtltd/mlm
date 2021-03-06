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
			$this->app->redirect($this->options['login_page']);
		}

		$menu = [
				['key'=>'dashboard','name'=>'Dashboard'],
				['key'=>'panelregistration', 'name'=>'Registration'],
				['key'=>'tree','name'=>'View'],
				['key'=>'repurchase','name'=>'Shopping'],
				['key'=>'mypayouts','name'=>'My Payouts'],
				['key'=>'distributorreports','name'=>'Reports'],
				// ['key'=>'mywallet','name'=>'My Wallet'],
				['key'=>'utility','name'=>'Utility'],
				['key'=>'setting','name'=>'Settings'],
			];

		$submenu_list = ['distributorreports'=>[
							'index.php?page=distributorreports&report=active-downline'=>'Active Downline',
							'index.php?page=distributorreports&report=active-intros-list'=>'Active Sponsored',
							'index.php?page=distributorreports&report=direct-downline-business'=>'Direct Downline Business',
							'index.php?page=distributorreports&report=inactive-downline'=>'Inactive Downline',
							'index.php?page=distributorreports&report=inactive-intros-list'=>'Inactive Sponsored',
							],
							'tree'=>[
								'genology'=>'Genology',
								'generation'=>'Generation'
							],
							'mypayouts'=>[
								// 'index.php?page=mypayouts&report=binary'=>'Binary',
								// 'index.php?page=mypayouts&report=generation'=>'Generation',
								'index.php?page=mypayouts&report=all'=>'All Payouts',
								'index.php?page=mypayouts&report=paid'=>'Paid Payouts',
							],
							'repurchase'=>[
									'repurchase'=>'Repurchase',
									'index.php?page=myorder&action=orderdetail'=>'Order Detail',
									'index.php?page=myorder&action=courierdetail'=>'Courier Detail',
									'index.php?page=myorder&action=invoicedetail'=>'Invoice Detail'
								],
							'utility'=>[
								'index.php?page=utility&type=gallery'=>'Gallery',
								'index.php?page=utility&type=download'=>'Download',
								'index.php?page=utility&type=welcomeletter'=>'Welcome Letter'
								]
						];

		$this->complete_lister = $cl = $this->add('CompleteLister',null,null,['view/distributormenu']);
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

		$cl->template->trySet('distributor_name',$distributor['name']);
		$cl->template->trySet('distributor_dp',($distributor['image']?:"shared/apps/xavoc/mlm/templates/img/profile.png"));

		$cl->template->trySet('distributor_name',$distributor['name']);
		$cl->template->trySet('user_name',$this->app->auth->model['username']);
		
		$this->js(true)->_selector('.dropdown-toggle')->dropdown();
	}
}