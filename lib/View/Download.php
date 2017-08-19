<?php

namespace xavoc\mlm;
class View_Download extends \View{

	function init(){
		parent::init();

		$download = $this->add('xavoc\mlm\Model_Download');
		$download->addCondition('status','Active');

		$grid = $this->add('xepan\base\Grid');
		$grid->setModel($download);
	}
}