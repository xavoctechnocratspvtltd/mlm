<?php


namespace xavoc\mlm;


class View_DistributorReport extends \View {

	public $report=null;
	public $distributor=null;

	function init(){
		parent::init();
		
		$this->report = $this->app->stickyGET('report');

		if(!$this->report){
			$this->add('View')->set("No Report Selected");
			return;
		}

		$this->distributor = $distributor = $this->add('xavoc\mlm\Model_Distributor');
		$distributor->loadLoggedIn();

		if(!$distributor->loaded()){
			$this->add('View')->set('No Distributor Found, please login again');
			return;
		}

		switch ($this->report) {
			case 'active-downline':
				$this->add('View')->setElement('h3')->set('Active Downline Report');
				$this->add('xavoc\mlm\View_Report_Distributor_Downline',['report_status'=>'active'])
						->setModel($this->distributor);
				break;
			case 'inactive-downline':
				$this->add('View')->setElement('h3')->set('Inactive Downline Report');
				$this->add('xavoc\mlm\View_Report_Distributor_Downline',['report_status'=>'inactive'])
						->setModel($this->distributor);
				break;
			case 'active-intros-list':
				$this->add('View')->setElement('h3')->set('Active Sponsored Report');
				$this->add('xavoc\mlm\View_Report_Distributor_Introductions',['report_status'=>'active'])
						->setModel($this->distributor);
				break;
			case 'inactive-intros-list':
				$this->add('View')->setElement('h3')->set('Inactive Sponsored Report');
				$this->add('xavoc\mlm\View_Report_Distributor_Introductions',['report_status'=>'inactive'])
						->setModel($this->distributor);
				break;
			case 'direct-downline-business':
				$this->add('View')->setElement('h3')->set('Direct Downline Report');
				$this->add('xavoc\mlm\View_Report_Distributor_Introductions',['report_status'=>'downline_business'])
						->setModel($this->distributor);
				break;
			default:
				# code...
				break;
		}
	}

	// function defaultTemplate(){
	// 	return ['view/distributorreport'];
	// }
}