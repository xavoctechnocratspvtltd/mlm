<?php

namespace xavoc\mlm;

/**
* 
*/
class Tool_DashBoard extends \xavoc\mlm\Tool_Distributor{
	public $options = [
				'show-status'=>null,
				'login_page'=>'login'
			];
	
	function init(){
		parent::init();

		if($this->owner instanceof \AbstractController) return;

		if($this->options['show-status']){
		}

		$this->distributor = $distributor = $this->add('xavoc\mlm\Model_Distributor');
		$distributor->loadLoggedIn();
		if(!$distributor->loaded()){
			return;
			// $this->add('xavoc\mlm\View_DistributorNotFound');
			// $this->add('View')->set('Distributor login Required');
			// $this->add('Button')->set('click to login')->js('click')->univ()->redirect($this->app->url($this->options['login_page']));
			// $this->app->redirect($this->app->url($this->options['login_page']));
		}

		$this->add('xavoc\mlm\View_ProfileChecker');

		$col = $this->add('Columns')->addClass('row');
		$col1 = $col->addColumn('4')->addClass('col-lg-4 col-md-4 col-sm-12 col-xs-12');
		$col2 = $col->addColumn('4')->addClass('col-lg-4 col-md-4 col-sm-12 col-xs-12');
		$col3 = $col->addColumn('4')->addClass('col-lg-4 col-md-4 col-sm-12 col-xs-12');
		
		$card_options = ['icon'=>'fa fa-trophy','header'=>'Current Rank','theme'=>'purple','title'=>$distributor['current_rank']?:"not achived"];
		$col1->add('xavoc\mlm\View_Card',['options'=>$card_options]);

		$card_options = ['icon'=>'fa fa-arrow-left','header'=>'Total Left Downline SV','theme'=>'blue','title'=>$distributor['total_left_sv']?:0];
		$col2->add('xavoc\mlm\View_Card',['options'=>$card_options]);

		$card_options = ['icon'=>'fa fa-arrow-right','header'=>'Total Right Downline SV','theme'=>'blue','title'=>$distributor['total_right_sv']?:0];
		$col3->add('xavoc\mlm\View_Card',['options'=>$card_options]);

		$card_options = ['icon'=>'fa fa-users','header'=>'Weekly Pair','theme'=>'orange','title'=>$distributor['week_pairs']?:0];
		$col1->add('xavoc\mlm\View_Card',['options'=>$card_options]);
		
		$card_options = ['icon'=>'fa fa-circle-o','header'=>'Month Self BV','theme'=>'green','title'=>$distributor['month_self_bv']?:0];
		$col2->add('xavoc\mlm\View_Card',['options'=>$card_options]);
		
		$card_options = ['icon'=>'fa fa-circle-o','header'=>'Total Month BV','theme'=>'green','title'=>$distributor['total_month_bv']?:0];
		$col3->add('xavoc\mlm\View_Card',['options'=>$card_options]);
		
	}

	function defaultTemplate(){
		return ['view/tool/distributor/dashboard'];
	}
}