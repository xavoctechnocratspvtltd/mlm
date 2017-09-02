<?php


namespace xavoc\mlm;

class page_report_sale extends \xepan\base\Page {
	public $title = "Sales report";

	function init(){
		parent::init();

		$this->from_date = $from_date = $this->app->stickyGET('from_date')?:$this->app->today;
		$this->to_date = $to_date = $this->app->stickyGET('to_date')?:$this->app->today;


		$form = $this->add('Form');
		$form->add('xepan\base\Controller_FLC')
			->layout([
					'date_range'=>'Filter reports for Date~c1~8',
					'FormButtons'=>'c2~4',
				]);
		$fld = $form->addField('DateRangePicker','date_range')
                ->setStartDate($this->app->today)
                ->setEndDate($this->app->today);

        $form->addSubmit('Filter')->addClass('btn btn-primary btn-block');

        $view = $this->add('View');
        $tabs = $view->add('Tabs');
        $top_tab = $tabs->addTab('Topups');
        $rep_tab = $tabs->addTab('Repurchase');
        
        $this->addTopupsReport($top_tab);
        $this->addRepReport($rep_tab);

        if($form->isSubmitted()){
        	$view->js()->reload(['from_date'=>$fld->getStartDate(),'to_date'=>$fld->getEndDate()])->execute();
        }

	}

	function addTopupsReport($tab){
		$model = $this->add('xavoc\mlm\Model_TopupHistory');
		$model->addCondition('created_at','>',$this->from_date);
		$model->addCondition('created_at','<',$this->app->nextDate($this->to_date));

		$grid = $tab->add('xepan\base\Grid');
		$grid->setModel($model,['distributor','kit_item','bv','sv','sale_price','sale_order','created_at','is_payment_verified','payment_mode']);
		$grid->addSno('Sr.No',true);
		$grid->addPaginator(100);

	}

	function addRepReport($tab){
		$model = $this->add('xavoc\mlm\Model_RepurchaseHistory');
		$model->addCondition('created_at','>',$this->from_date);
		$model->addCondition('created_at','<',$this->app->nextDate($this->to_date));

		$grid = $tab->add('xepan\base\Grid');
		$grid->setModel($model,['distributor','total_dp','total_bv','total_sv','sale_order','created_at','is_payment_verified','payment_mode']);
		$grid->addSno('Sr.No',true);
		$grid->addPaginator(100);
	}
}