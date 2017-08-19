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

		$this->distributor = $distributor = $this->add('xavoc\mlm\Model_Distributor');
		$distributor->addExpression('registration_date')->set('DATE(created_at)');
		$distributor->addExpression('activation_date')->set('DATE(greened_on)');

		$distributor->addExpression('package_name')->set(function($m,$q){
			$task = $m->add('xepan\commerce\Model_Item',['table_alias'=>'package_item'])
				->addCondition('id',$m->getElement('kit_item_id'));
				// ->fieldQuery('name'); 
			return $q->expr('[0]',[$task->fieldQuery('name')]);
		});

		$distributor->addExpression('package_code')->set(function($m,$q){
			$task = $m->add('xepan\commerce\Model_Item',['table_alias'=>'package_item'])
				->addCondition('id',$m->getElement('kit_item_id'));
			return $q->expr('[0]',[$task->fieldQuery('sku')]);
		});
		$distributor->addExpression('package_amount')->set(function($m,$q){
			return $task = $m->add('xepan\commerce\Model_Item',['table_alias'=>'package_item'])
				->addCondition('id',$m->getElement('kit_item_id'))
				->fieldQuery('sale_price');
		});

		$distributor->loadLoggedIn();
		if(!$distributor->loaded()){
			return;
			// $this->add('xavoc\mlm\View_DistributorNotFound');
			// $this->add('View')->set('Distributor login Required');
			// $this->add('Button')->set('click to login')->js('click')->univ()->redirect($this->app->url($this->options['login_page']));
			// $this->app->redirect($this->app->url($this->options['login_page']));
		}

		$this->addClass('main-box');
		$config_model = $this->add('xepan\base\Model_ConfigJsonModel',
		[
			'fields'=>[
						'recent_news'=>'text',
					],
				'config_key'=>'DM_RECENTNEWS',
				'application'=>'mlm'
		]);
		$config_model->tryLoadAny();
		$this->add('View',null,'news_section')
				->setElement('marquee')
				// ->setAttr('direction','right')
				->setStyle('font-size','16px')
				->setHtml($config_model['recent_news']);


		$this->add('xavoc\mlm\View_ProfileChecker',null,'profile');
		$profile_info = $this->add('View',null,'profile',['view/tool/distributor/dashboard','profile']);
		$profile_info->setModel($distributor);


		$col = $this->add('Columns',null,'right_section')->addClass('row');
		$col1 = $col->addColumn('4')->addClass('col-lg-4 col-md-4 col-sm-12 col-xs-12');
		$col2 = $col->addColumn('4')->addClass('col-lg-4 col-md-4 col-sm-12 col-xs-12');
		$col3 = $col->addColumn('4')->addClass('col-lg-4 col-md-4 col-sm-12 col-xs-12');

		$view_box = $col1->add('View')->addClass('panel panel-info alert');
		
		$kit_model = $this->add('xavoc\mlm\Model_Kit');
		$kit_model->addExpression('capping_int')->set(function($m,$q){
			return $q->expr('CAST([0] AS SIGNED)',[$m->getElement('capping')]);
		});
		$last_kit = $this->add('xavoc\mlm\Model_TopupHistory')
		->addCondition('distributor_id',$distributor->id)
		->setOrder('id','desc')
		->tryLoadAny()
		;
		if($last_kit->loaded())
			$kit_model->addCondition('capping_int','>',$last_kit['capping']);
		else{
			$kit_model->addCondition('capping_int','>',$distributor['capping']);
		}
		if($kit_model->count()->getOne()){
			$view_box->add('View')->setElement('a')->set('Upgrade Package Request')->js('click')->univ()->redirect($this->app->url('kit'));
		}else{
			$view_box->add('View_Box')->setHTML('<i class="glyphicon glyphicon-ok"></i> Topup Updated')->addClass('text-success text-center');
		}


		$view_box = $col2->add('View')->addClass('panel panel-info alert');//->setStyle('height','80px;');
		if(!$distributor['attachment_count']){
			$view_box->add('View_Box')->setHTML('<i class="glyphicon glyphicon-ok"></i> KYC Updated')->addClass('text-success text-center');
		}else{
			$view_box->add('View')->addClass('text-danger text-center')->setHtml('<i class="glyphicon glyphicon-remove"></i> UPDATE KYC')->js('click')->univ()->redirect($this->app->url('setting'));
		}

		$view_box = $col3->add('View')->addClass('panel panel-info alert');
		if(!$distributor['is_verified']){
			$view_box->add('View')->addClass('text-danger')->setHtml('<i class="glyphicon glyphicon-remove"></i> Verification Pending');
		}else{
			$view_box->add('View')->set('Verification Done');
		}

		$text_color = trim(strtolower(str_replace("star", " ",$distributor['current_rank'])));
		$text_color = trim(str_replace("star", " ",$text_color));

		if($text_color == "yellow")
			$text_color =  '#CCCC00';
		
		$view_box = $col1->add('View')->addClass('panel panel-info alert text-right')->setStyle('height','80px;');
		$view_box->add('View')->setHtml('Current Rank');
		$view_box->add('View')->setHtml('<strong style="color:'.$text_color.';">'.strtoupper($distributor['current_rank']).'</strong>');

		$view_box = $col2->add('View')->addClass('panel panel-info alert text-right')->setStyle('height','80px;');
		$view_box->add('View')->setHtml('Total Downline SV (Left)');
		$view_box->add('View')->setHtml('<strong style="color:'.$text_color.'">'.strtoupper($distributor['total_left_sv'].'</strong>'));

		$view_box = $col3->add('View')->addClass('panel panel-info alert text-right')->setStyle('height','80px;');
		$view_box->add('View')->setHtml('Total Downline SV (Right)');
		$view_box->add('View')->setHtml('<strong style="color:'.$text_color.'">'.strtoupper($distributor['total_right_sv']).'</strong>');


		$view_box = $col1->add('View')->addClass('panel panel-info alert text-right')->setStyle('height','80px;');
		// $view_box->add('View')->setHtml('');
		// $view_box->add('View')->set(strtoupper($distributor['current_rank']));

		$view_box = $col2->add('View')->addClass('panel panel-info alert text-right')->setStyle('height','80px;');
		$view_box->add('View')->setHtml('Current Week Matching SV');
		$view_box->add('View')->setHtml('<strong style="color:'.$text_color.'">'.strtoupper($distributor['week_pairs'].'</strong>'));

		$view_box = $col3->add('View')->addClass('panel panel-info alert text-right')->setStyle('height','80px;');
		$view_box->add('View')->setHtml('Total Matching SV');
		$view_box->add('View')->setHtml('<strong>'.strtoupper('---').'</strong>');


		$view_box = $col1->add('View')->addClass('panel panel-info alert text-right')->setStyle('height','80px;');
		$view_box->add('View')->setHtml('Prev. Cumulative BV');
		$view_box->add('View')->set('---');

		$view_box = $col2->add('View')->addClass('panel panel-info alert text-right')->setStyle('height','80px;');
		$view_box->add('View')->setHtml('Current Cumulative BV');
		$view_box->add('View')->setHtml('<strong style="color:'.$text_color.'">'.strtoupper($distributor['total_month_bv'].'</strong>'));

		$view_box = $col3->add('View')->addClass('panel panel-info alert text-right')->setStyle('height','80px;');
		$view_box->add('View')->setHtml('Current Month Personal BV');
		$view_box->add('View')->setHtml('<strong style="color:'.$text_color.'">'.strtoupper($distributor['month_self_bv']).'</strong>');
		
		// $card_options = ['icon'=>'fa fa-arrow-left','header'=>'Total Left Downline SV','theme'=>'blue','title'=>$distributor['total_left_sv']?:0];
		// $col2->add('xavoc\mlm\View_Card',['options'=>$card_options]);

		// $card_options = ['icon'=>'fa fa-arrow-right','header'=>'Total Right Downline SV','theme'=>'blue','title'=>$distributor['total_right_sv']?:0];
		// $col3->add('xavoc\mlm\View_Card',['options'=>$card_options]);

		// $card_options = ['icon'=>'fa fa-users','header'=>'Weekly Pair','theme'=>'orange','title'=>$distributor['week_pairs']?:0];
		// $col1->add('xavoc\mlm\View_Card',['options'=>$card_options]);
		
		// $card_options = ['icon'=>'fa fa-circle-o','header'=>'Month Self BV','theme'=>'green','title'=>$distributor['month_self_bv']?:0];
		// $col2->add('xavoc\mlm\View_Card',['options'=>$card_options]);
		
		// $card_options = ['icon'=>'fa fa-circle-o','header'=>'Total Month BV','theme'=>'green','title'=>$distributor['total_month_bv']?:0];
		// $col3->add('xavoc\mlm\View_Card',['options'=>$card_options]);
		
	}

	function defaultTemplate(){
		return ['view/tool/distributor/dashboard'];
	}
}