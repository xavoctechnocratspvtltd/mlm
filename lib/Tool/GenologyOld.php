<?php

namespace xavoc\mlm;

/**
* 
*/
class Tool_Genology extends \xepan\cms\View_Tool{
	
	public $options = [
						'genology-depth-of-tree'=> 5,
						'genology-show-info-on'=>"hover"
	];

	public $distributor = null ;
	public $start_distributor = null ;
	public $start_id = null ;
	public $level = 5 ;

	function init(){
		parent::init();

		if($this->owner instanceof \AbstractController) return;

		if($this->app->auth->model->isSuperUser()){
			return "please login with distributor id";
		}

		$this->distributor = $distributor = $this->add('xavoc\mlm\Model_Distributor_Genology');
		$distributor->loadLoggedIn();

		if($this->api->stickyGET('start_id')){
			$this->start_id = $_GET['start_id'];
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

		$this->start_distributor = $this->add('xavoc\mlm\Model_Distributor_Genology')->load($this->start_id);

		$form = $this->add('Form');
		$user_field = $form->addField('line','username');
		$user_field->afterField()->add('Button')->set(array(' ','icon'=>'search'));

		if($form->isSubmitted()){
			$model = $this->add('xavoc\Model_Distributor_Genology')->tryLoadBy('username',$form['username']);
			if(!$model->loaded())
				$form->displayError('username','No, User found with this username');
			if(!$this->api->auth->model->isBackEndUser()){
				if(!$distributor->isInDown($model)){
					$form->displayError('username','Looks like, Not in your Downline');
				}
			}
			$this->js()->reload(array('start_id'=>$model->id))->execute();
		}

		$this->add('View_Info')->set('Genology Tool '. $this->options['genology-show-info-on']);
	}

	function renderModel($model,$level){

		$output="";
		$reload_js = $this->js()->reload(array('start_id'=>$model->id));
		$t=$this->template->cloneRegion('Node');
		$t->setHTML('username','<a href="#xepan" onclick="'.$reload_js->render().'">'.$model['name']."-".$model['id'].'</a>');
		$t->set('class',($model['greened_on'])?'text-success':($model['kit_item_id']?'text-warning':'text-danger'));
		if($model['greened_on'] !== null)
			$greened_on_date = date("d M Y", strtotime($model['greened_on']));
		else
			$greened_on_date = "--/---/----";
		
		$t->set('title',
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
							<td>Orange</td>
							<td>". $model->newInstance()->addCondition('path','like',$model['path'].'A%')->addCondition('ansestors_updated',false)->count()->getOne() ."</td>
							<td>". $model->newInstance()->addCondition('path','like',$model['path'].'B%')->addCondition('ansestors_updated',false)->count()->getOne() ."</td>
						</tr>
						<tr>
							<td>Green</td>
							<td>". $model->newInstance()->addCondition('path','like',$model['path'].'A%')->addCondition('greened_on','<>',null)->addCondition('ansestors_updated',true)->count()->getOne() ."</td>
							<td>". $model->newInstance()->addCondition('path','like',$model['path'].'B%')->addCondition('greened_on','<>',null)->addCondition('ansestors_updated',true)->count()->getOne() ."</td>
						</tr>
					</table>
					"
				);

		if($model['left_id'] and $level-1 > 0){
			$l_m= $this->add('xavoc\mlm\Model_Distributor_Genology')->load($model['left_id']);
			$t->setHTML('leftnode',$this->renderModel($l_m,$level-1));
		}else{
			$t->trySet('sponsor_id',$model->id);
			if($model['left_id'])
				$t->setHTML('leftnode','<i class="fa fa-user fa-2x"></i>');
			else
				$t->setHTML('leftnode','<i class="fa fa-cog fa-2x"></i>');
			// $t->tryDel('leftnode');
		}

		if($model['right_id'] and $level-1 > 0){
			$r_m= $this->add('xavoc\mlm\Model_Distributor_Genology')->load($model['right_id']);
			$t->setHTML('rightnode',$this->renderModel($r_m,$level-1));
		}else{
			$t->trySet('sponsor_id',$model->id);
			if($model['right_id'])
				$t->setHTML('rightnode','<i class="fa fa-user fa-2x"></i>');
			else
				$t->setHTML('rightnode','<i class="fa fa-cog fa-2x"></i>');
			// $t->tryDel('rightnode');
		}

		$output.=$t->render();
		return $output;
	}

	function render(){

		if($this->start_id){

			$this->js()->_load('xtooltip');

			$reload_parent_js = $this->js()->reload(array('start_id'=>$this->start_distributor['sponsor_id']));
			$distributor_tree_js = $this->js()->reload(array('start_id'=>$this->distributor->id));

			$r=$this->renderModel($this->add('xavoc\mlm\Model_Distributor_Genology','d')->load($this->start_id),$this->level);
	        $this->template->setHTML('Tree',$r);
	        if($this->start_id != $this->distributor->id && $this->start_distributor['sponsor_id']){
		        $this->template->setHTML('ParentURL',$reload_parent_js->render());
		        $this->template->setHTML('MyURL',$distributor_tree_js->render());
	        }
		    else{
		    	$this->template->del('Parent');
		    }
	        $this->template->del('Node');
	        $this->js(true)->_selector('.main_div')->xtooltip();
		}
		return parent::render();
	}

	function defaultTemplate(){
		return array('xavoc/tool/genology');
	}
}
						
