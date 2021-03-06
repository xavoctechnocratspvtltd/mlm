<?php

namespace xavoc\mlm;

/**
* 
*/
class View_GenologyDynamic extends \View{
	
	public $options = [
						'genology-depth-of-tree'=> 3,
						'genology-show-info-on'=>"hover"
	];

	public $distributor = null ;
	public $start_distributor = null ;
	public $start_id = null ;
	public $level = 1 ;

	function init(){
		parent::init();

		if($this->app->auth->model->isSuperUser()){
			return "please login with distributor id";
		}

		$this->level = $this->options['genology-depth-of-tree'];

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
		$this->template->trySet('sponsor_id',$a['sponsor_id']);
		$this->template->trySet('url',$this->app->url());


	}

	function drawNode($parent_id,$id,$depth){
		if($depth == 0 ) return;
		$m=$this->add('xavoc\mlm\Model_Distributor');
		$m->load($id);
		$clr=($m['greened_on']) ? "folder_green.gif" : "folder_red.gif";
		$title= $this->getTitle($m);
		$this->js(true,"addNode($id,$parent_id,'".$m['name']." <br/> [".$m['user']."]', '$clr','$title')");
		if($m['left_id'])
			$this->drawNode($id,$m['left_id'],$depth-1);
		else if($depth-1 > 0)
			$this->js(true,"addNode(-${id}0001,$id,'A','question.gif')");
		if($m['right_id'])
			$this->drawNode($id,$m['right_id'],$depth-1);
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
				"<br/>Kit: ". $model['kit_item'] ." SV(".$model['sv'].")"."BV(".$model['bv'].")".
				"<br/>Intro: ". $model['introducer'] .
				"<br/><table border='1' width='100%'>
					<tr>
						<th> Session </th><th> Left </th><th> Right </th>
					</tr>
					<tr>
						<th>SV</th><td>".$model['day_left_sv']."</td><td>".$model['day_right_sv']."</td>
					</tr>
					</table>
					<div class='atk-box-small'>Gen Business: ".$model['generation_business']."</div>
					<div class='atk-box-small'>Month Self BV: ".$model['month_self_bv']."</div>
					<div class='atk-box-small atk-swatch-green'>Session Intros: ".$model['session_intros_amount']." /-</div>
					<div class='atk-box-small atk-size-mega atk-swatch-green'>Downline</div>
					<table border='1' width='100%'>
						<tr>
							<td>&nbsp;</td>
							<td>Left</td>
							<td>Right</td>
						</tr>
						<tr>
							<td>Total</td>
							<td>". $model->newInstance()->addCondition('path','like',$model['path'].'A%')->count()->getOne() ."</td>
							<td>". $model->newInstance()->addCondition('path','like',$model['path'].'B%')->count()->getOne() ."</td>
						</tr>
						<tr>
							<td>Green</td>
							<td>". $model->newInstance()->addCondition('path','like',$model['path'].'A%')->addCondition('greened_on','<>',null)->addCondition('ansestors_updated',true)->count()->getOne() ."</td>
							<td>". $model->newInstance()->addCondition('path','like',$model['path'].'B%')->addCondition('greened_on','<>',null)->addCondition('ansestors_updated',true)->count()->getOne() ."</td>
						</tr>
					</table>
					";
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
		return array('xavoc/tool/genology-new-tree');
	}
}
						
