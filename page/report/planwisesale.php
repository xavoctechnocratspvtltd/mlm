<?php


namespace xavoc\mlm;

class page_report_planwisesale extends \xavoc\mlm\page_report {

	function init(){
		parent::init();

		$tab = $this->add('Tabs');

		$tab->addTabURL('xavoc_dm_report_sale_topup','New Joining');
		$tab->addTabURL('xavoc_dm_report_sale_repurchase','Repurchase');
		
	}
}