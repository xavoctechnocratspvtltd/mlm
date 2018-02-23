<?php


namespace xavoc\mlm;

class page_report_cappdistlist extends \xepan\base\Page {
	public $title = "Distributor Capping List";

	function init(){
		parent::init();

		$this->from_date = $from_date = $this->app->stickyGET('from_date')?:$this->app->today;
		$this->to_date = $to_date = $this->app->stickyGET('to_date')?:$this->app->today;

		$form = $this->add('Form');
		$form->add('xepan\base\Controller_FLC')
			->makePanelsCoppalsible(true)
			->layout([
					'date_range'=>'Filters~c1~8',
					'FormButtons~'=>'c2~2',
				]);
		$fld = $form->addField('DateRangePicker','date_range')
                ->setStartDate($this->app->today)
                ->setEndDate($this->app->today);

        $form->addSubmit('Filter')->addClass('btn btn-primary btn-block');

        $view = $this->add('View');

        $payout_m = $this->add('xavoc\mlm\Model_Payout');
        $dist_j = $payout_m->join('mlm_distributor.distributor_id','distributor_id');
        $dist_j->addField('capping');
        $kit_j  = $dist_j->Leftjoin('item.document_id','kit_item_id');
        $kit_j->addField('kit_name','name');

        $payout_m->addCondition('binary_income',$payout_m->getElement('capping'));
        $payout_m->addCondition('binary_income','>',0);

        $payout_m->addCondition('closing_date','>=',$this->from_date);
        $payout_m->addCondition('closing_date','<',$this->app->nextDate($this->to_date));

        $grid = $view->add('Grid');
        $grid->setModel($payout_m,['distributor','closing','closing_date','binary_income','capping','kit_name']);
        
        $grid->addPaginator($ipp=100);

        $grid->add('xavoc\mlm\View_Export');
        if($form->isSubmitted()){
        	$view->js()->reload(['from_date'=>$fld->getStartDate(),'to_date'=>$fld->getEndDate()])->execute();
        }
	}
}