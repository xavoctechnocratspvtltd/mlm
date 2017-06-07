<?php

namespace xavoc\mlm;


class page_runtests extends \xepan\base\Page_TestRunner {
	
	public $title='DS MArketing test cases';
	public $dir='tests';
	public $namespace = __NAMESPACE__;
	public $page_router = 'xavoc\dm';

	function init(){
		if(!set_time_limit(0)) throw new \Exception("Could not limit time", 1);
		parent::init();

	}

}
