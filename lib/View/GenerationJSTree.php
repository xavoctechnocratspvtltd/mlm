<?php

namespace xavoc\mlm;

/**
* 
*/
class View_GenerationJSTree extends \View{
	
	public $options = [
						'generation-depth-of-tree'=> 3,
						'generation-show-info-on'=>"hover"
	];

	public $distributor = null ;
	public $start_distributor = null ;
	public $start_id = null ;
	public $level = 5 ;

	function init(){
		parent::init();

		$this->js()->_load('xtooltip');
		$this->js()->_load('jstree\dist\jstree.min');
		$this->app->jui->addStaticStyleSheet('jstree/dist/themes/default/style.min');

		if($this->app->auth->model->isSuperUser()){
			return "please login with distributor id";
		}
		$this->level = $this->options['generation-depth-of-tree'];

		$this->js(true)->jstree(['core'=>[
						'data'=>[
								'url'=>$this->app->js(null,'return ev.id ==="#" ? "index.php?page=xavoc_dm_gene":"index.php?page=xavoc_dm_gene"')->_enclose(),
								"dataType" => "json",
								"data"=> $this->app->js(null,"console.log(ev);return {'id':ev.id}")->_enclose()
							]
					]]);
		$this->js(true)->xtooltip();
	}

	
	
	// function defaultTemplate(){
	// 	return array('xavoc/tool/generation-new-tree');
	// }
}
						
