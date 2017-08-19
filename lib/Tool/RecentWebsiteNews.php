<?php

namespace xavoc\mlm;

/**
* 
*/
class Tool_RecentWebsiteNews extends \xepan\cms\View_Tool{ 
	
	public $options = [];

	function init(){
		parent::init();

		$config_model = $this->add('xepan\base\Model_ConfigJsonModel',
			[
				'fields'=>[
							'recent_news'=>'xepan\base\RichText',
						],
					'config_key'=>'DM_RECENTWEBSITENEWS',
					'application'=>'mlm'
			]);
		$config_model->tryLoadAny();

		$this->add('View')->setHtml($config_model['recent_news']);


	}
}