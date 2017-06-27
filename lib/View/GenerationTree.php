<?php

namespace xavoc\mlm;

/**
* 
*/
class View_GenerationTree extends \View{
	
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

		if($this->app->auth->model->isSuperUser()){
			return "please login with distributor id";
		}

		$this->level = $this->options['generation-depth-of-tree'];

		$this->distributor = $distributor = $this->add('xavoc\mlm\Model_Distributor_Genology');
		$distributor->loadLoggedIn();

		if($this->api->stickyGET('start_id')){
			if(!is_numeric($_GET['start_id'])){
				$this->start_id = $this->add('xavoc\mlm\Model_Distributor')
							->addCondition([['user',$_GET['start_id']],['name','like','%'.$_GET['start_id'].'%'],['id',$_GET['start_id']]])
							->tryLoadAny()
							->get('id');
			}else{
				$this->start_id = $_GET['start_id'];
			}
		}

		if(!$this->start_id){
			$this->start_id = $distributor->id;
		}else{
			if(!$this->api->auth->model->isSuperUser()){
				if(!$distributor->isInDown($this->add('xavoc\mlm\Model_Distributor_Genology')->tryLoad($this->start_id))){
					$this->add('View_Error')->set('You are not Authorized to look out of your Tree');
					$this->start_id = $distributor?$distributor->id: null;
				}
			}
		}

		$this->drawNode(-1,$this->start_id,$this->level);
		$this->js(true,"displayTree()");
		$this->js(true)->_load('xtooltip');
		
		$a=$this->add('xavoc\mlm\Model_Distributor');
		$a->load($this->start_id);
		$this->template->trySet('introducer_id',$a['introducer_id']);
		$this->template->trySet('url',$this->app->url());


	}

	function drawNode($parent_id,$id,$depth){
		if($depth == 0 ) return;
		$m=$this->add('xavoc\mlm\Model_Distributor');
		$m->load($id);
		$clr=($m['greened_on']) ? "folder_green.gif" : "folder_blue.gif";
		$title = $this->getTitle($m);
		$this->js(true,"addNode($id,$parent_id,'".$m['name']." <br/> [".$m['user']."]', '$clr','$title')");

		$distributor = $this->add('xavoc\mlm\Model_Distributor');
		$distributor->addCondition('introducer_id',$m->id);

		if($distributor->count()->getOne()){
			foreach ($distributor as $dist) {
				$this->drawNode($id,$dist->id,$depth-1);
			}
		}

		// if($m['right_id'] <> null)
		// 	$this->drawNode($id,$m['right_id'],$depth-1);
		// else if($depth-1 > 0)
		// 	$this->js(true,"addNode(-${id}0002,$id,'B','question.gif')");

		$m->unload();
		$m->destroy();
	}

	function getTitle($model){
		if($model['greened_on'] !== null)
			$greened_on_date = date("d M Y", strtotime($model['greened_on']));
		else
			$greened_on_date = "--/---/----";
		$str=  
				$model['name'].
				"<br/>Jn: ". date("d M Y", strtotime($model['created_at'])). 
				"<br/>Gr: ". $greened_on_date. 
				"<br/>Kit: ". ($model['kit_item']?:'') ." SV(".$model['sv'].")"."BV(".$model['bv'].")".
				"<br/>Intro: ". $model['introducer'] .
				"<br/>Month Self BV: ". $model['month_self_bv'];
				
		$str= str_replace("'", "\'", $str);
		$str= str_replace("\n", "", $str);
		return $str;
	}
	// function render(){
		// $this->js(true,"addNode(-1,0,'".$a['name']."')");
		// $this->drawNode(-1,$this->start_id,$this->level);
		// $this->js(true,"displayTree()");
		
		// $a=$this->add('xavoc\mlm\Model_Distributor');
		// $a->load($this->start_id);
		// $this->template->trySet('sponsor_id',$a['sponsor_id']);
		// parent::render();
	// }
	function defaultTemplate(){
		return array('xavoc/tool/generation-new-tree');
	}
}
						
