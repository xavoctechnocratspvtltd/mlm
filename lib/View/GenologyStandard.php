<?php

namespace xavoc\mlm;

/**
* 
*/
class View_GenologyStandard extends \View{
	
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

		$this->level = $this->options['genology-depth-of-tree'];

		$form = $this->add('Form');
		$form->add('xepan\base\Controller_FLC')
			->makePanelsCoppalsible()
			->layout([
					'username~search by user name or user id'=>'SEARCH~c1~8~closed',
					'FormButtons~'=>'c2~4'
				]);
		$user_field = $form->addField('line','username')->addClass('field-group');
		$form->addSubmit('Search')->addClass('btn btn-xs btn-primary');

		if($form->isSubmitted()){
			$model = $this->add('xavoc\mlm\Model_Distributor_Genology')
						->addCondition([['user',$form['username']],['name','like','%'.$form['username'].'%'],['id',$form['username']]])
						->tryLoadAny();
			if(!$model->loaded())
				$form->displayError('username','No, User found with this username');
			if(!$this->api->auth->model->isSuperUser()){
				if(!$distributor->isInDown($model)){
					$form->displayError('username','Looks like, Not in your Downline');
				}
			}
			$this->js()->reload(array('start_id'=>$model->id))->execute();
		}

	}

	function renderModel($model,$level){

		$output="";
		$reload_js = $this->js()->reload(array('start_id'=>$model->id));
		$t=$this->template->cloneRegion('Node');
		$t->setHTML('username','<a href="'.($this->app->url('.')->absolute()).'#xepan" onclick="'.$reload_js->render().'">'.$model['name']."-".$model['user'].'</a>');
		$t->set('class',($model['greened_on'])?'text-success ds-icon-success':($model['kit_item_id']?'text-warning':'text-danger ds-icon-danger'));
		if($model['greened_on'] !== null)
			$greened_on_date = date("d M Y", strtotime($model['greened_on']));
		else
			$greened_on_date = "--/---/----";
		
		$t->set('title',$this->getTitle($model));

		if($model['left_id'] and $level-1 > 0){
			$l_m= $this->add('xavoc\mlm\Model_Distributor_Genology')->load($model['left_id']);
			$t->setHTML('leftnode',$this->renderModel($l_m,$level-1));
		}else{
			$t->trySet('sponsor_id',$model->id);
			if($model['left_id'])
				$t->setHTML('leftnode','<i class="ds-icon-gray"></i>');
			else
				$t->setHTML('leftnode','<i class="fa fa-cog fa-2x "></i>');
			// $t->tryDel('leftnode');
		}

		if($model['right_id'] and $level-1 > 0){
			$r_m= $this->add('xavoc\mlm\Model_Distributor_Genology')->load($model['right_id']);
			$t->setHTML('rightnode',$this->renderModel($r_m,$level-1));
		}else{
			$t->trySet('sponsor_id',$model->id);
			if($model['right_id'])
				$t->setHTML('rightnode','<div class="ds-icon-gray fa-2x"></div>');
			else
				$t->setHTML('rightnode','<i class="fa fa-cog fa-2x"></i>');
			// $t->tryDel('rightnode');
		}

		$output.=$t->render();
		return $output;
	}

	function getTitle($model){
		if($model['greened_on'] !== null)
			$greened_on_date = date("d M Y", strtotime($model['greened_on']));
		else
			$greened_on_date = "--/---/----";
		if($model['kit_item_id']){
			$kit_model = $this->add('xepan/commerce/Model_Item')->tryLoad($model['kit_item_id']);
			$kit_item = $kit_model['sku'];
		}
		else
			$kit_item="-";

		$str = "<table class='tooltipdetail'  style='width:100%;text-align:left;'>
				  <tr>
				  	<th style='width:30%;'>Name</th>
				  	<th> : ".$model['name'].' ('.$model['user'].')'."</th>
				  </tr>
				  <tr>
				  	<th>Reg Date</th>
				  	<th> : ".date("d M Y", strtotime($model['created_at']))."</th>
				  </tr>
				  <tr>
				  	<th>Act Date</th>
				  	<th> : ".$greened_on_date."</th>
				  </tr>
				  <tr>
				  	<th>Package</th>
				  	<th>:".$kit_item."<br/>:SV:(".$model['sv'].") BV:(".$model['bv'].")</th>
				  </tr>
				  <tr>
				  	<th>Intro</th>
				  	<th>:".$model['introducer']."</th>
				  </tr>
				</table>
				<br/>
				<table style='width:100%;text-align:left;' class='tooltipdetail'>
					<tr>
			    		<th style='text-align:left;'>Total Team (Left)<br/>".$model->newInstance()->addCondition('path','like',$model['path'].'A%')->count()->getOne()."</th>
			    		<th style='text-align:right;'>Total Team (Right)<br/>".$model->newInstance()->addCondition('path','like',$model['path'].'B%')->count()->getOne()."</th>
				    </tr>
				    <tr>
				    	<th><br/></th>
				    	<th><br/></th>
				    </tr>
					<tr>
						<th style='text-align:left !important;width:50%;'>Total SV (Left)<br/>".$model['total_left_sv']."</th>
				    	<th style='text-align:right !important;width:50%;'>Total SV (Right)<br/>".$model['total_right_sv']."</th>
					</tr>
					<tr>
				    	<th><br/></th>
				    	<th><br/></th>
				    </tr>
				    <tr>
				    	<th style='text-align:left;'>Month Self BV<br/>".$model['month_self_bv']."</th>
				    	<th style='text-align:right;'>Accumulated BV<br/>".$model['total_month_bv']."</th>
				    </tr>
				</table>
				";
		// $str= 
		// 		$model['name'].
		// 		"<br/>Jn: ". date("d M Y", strtotime($model['created_at'])). 
		// 		"<br/>Gr: ". $greened_on_date. 
		// 		"<br/>Kit: ". $kit_item ." SV(".$model['sv'].")"."BV(".$model['bv'].")".
		// 		"<br/>Intro: ". $model['introducer'] .
		// 		"<br/><table border='1' width='100%'>
		// 			<tr>
		// 				<th> Session </th><th> Left </th><th> Right </th>
		// 			</tr>
		// 			<tr>
		// 				<th>SV</th><td>".$model['day_left_sv']."</td><td>".$model['day_right_sv']."</td>
		// 			</tr>
		// 			</table>
		// 			<div class='atk-box-small'>Gen Business: ".$model['generation_business']."</div>
		// 			<div class='atk-box-small'>Month Self BV: ".$model['month_self_bv']."</div>
		// 			<div class='atk-box-small atk-swatch-green'>Session Intros: ".$model['session_intros_amount']." /-</div>
		// 			<div class='atk-box-small atk-size-mega atk-swatch-green'>Downline</div>
		// 			<table border='1' width='100%'>
		// 				<tr>
		// 					<td>&nbsp;</td>
		// 					<td>Left</td>
		// 					<td>Right</td>
		// 				</tr>
		// 				<tr>
		// 					<td>Total</td>
		// 					<td>". $model->newInstance()->addCondition('path','like',$model['path'].'A%')->count()->getOne() ."</td>
		// 					<td>". $model->newInstance()->addCondition('path','like',$model['path'].'B%')->count()->getOne() ."</td>
		// 				</tr>
		// 				<tr>
		// 					<td>Green</td>
		// 					<td>". $model->newInstance()->addCondition('path','like',$model['path'].'A%')->addCondition('greened_on','<>',null)->addCondition('ansestors_updated',true)->count()->getOne() ."</td>
		// 					<td>". $model->newInstance()->addCondition('path','like',$model['path'].'B%')->addCondition('greened_on','<>',null)->addCondition('ansestors_updated',true)->count()->getOne() ."</td>
		// 				</tr>
		// 			</table>
		// 			";
		$str= str_replace("'", "\'", $str);
		$str= str_replace("\n", "", $str);
		return $str;
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
	        $this->js(true)->_selector('.main_div')->tooltip(["placement"=>'bottom','html'=>true]);
	        // $this->js(true)->_selector('.main_div')->xtooltip();
		}
		return parent::render();
	}

	function defaultTemplate(){
		return array('xavoc/tool/genology');
	}
}
						
// OLD Hover HTML Layout
						// 				  <tr>
				  // 	<td>
				  //   	<table  style='width:100%'>
				  //          <tr>
				  //   			<td >Session:<br/> SV</td>
				  //   			<td >Left:- <br/>".$model['day_left_sv']."</td>
				  //   			<td > Right:- <br/>".$model['day_right_sv']."</td>
				  // 			</tr>
				  // 			<tr>
				  //   			<td>Gen. Business:-<br/> ".$model['generation_business']." </td>
				  //   			<td>Month Staff BV:-<br/> ".$model['month_self_bv']."</td>
				  //   			<td>Session Intro:-<br/>".$model['session_intros_amount']." /-</td>
				  // 			</tr>
				  // 			<tr>
				  //             <th >Downline </th>
				  //             <th >Left</th>
				  //             <th >Right</th>
				  //           </tr>
				  //           <tr>
				  //             <td>Total<br/>Green</td>
				  //             <td>".$model->newInstance()->addCondition('path','like',$model['path'].'A%')->count()->getOne() .
				  //             "<br/>".
				  //             		$model->newInstance()->addCondition('path','like',$model['path'].'A%')->addCondition('greened_on','<>',null)->addCondition('ansestors_updated',true)->count()->getOne() ."</td>
				              
				  //             <td>". $model->newInstance()->addCondition('path','like',$model['path'].'B%')->count()->getOne() .
				  //             "<br/>
				  //             		". $model->newInstance()->addCondition('path','like',$model['path'].'B%')->addCondition('greened_on','<>',null)->addCondition('ansestors_updated',true)->count()->getOne() ."
				  //             </td>
				  //           </tr>
				  //       </table>
				  //   </td>    
				  // </tr>	
