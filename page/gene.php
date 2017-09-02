<?php


namespace xavoc\mlm;

class page_gene extends \Page {

	function init(){
		parent::init();
		
		$this->distributor = $distributor = $this->add('xavoc\mlm\Model_Distributor_Genology');
		$distributor->loadLoggedIn();

		$id = $_GET['id']!=='#'?$_GET['id']:$distributor->id;

		// echo '[{"id":1,"text":"Root node","children":[{"id":2,"text":"Child node 1","children":true},{"id":3,"text":"Child node 2"}]}]';
		// exit;

		$intros = $this->add('xavoc\mlm\Model_Distributor')
						->addCondition('introducer_id',$id);

		$intros->addExpression('has_children')->set(function ($m,$q){
			return $this->add('xavoc\mlm\Model_Distributor',['table_alias'=>'in'])
						->addCondition('introducer_id',$q->getField('id'))
						->count();
		})->type('boolean');

		// $intros->addExpression('parent')->set('IF(introducer_id='.$id.',"#",introducer_id)');
		// $intros->addExpression('children')->set('true');

		$array = [];
		foreach ($intros as $key => $data) {

			$array[] = ['id'=>$data['id'],
						'text'=>$data['first_name'].' '.$data['last_name'] . ' ['.$data['user'].']',
						'parent'=>$data['introducer_id']==$distributor->id?"#":$data['introducer_id'],
						'children'=>$data['has_children']?true:false,
						'li_attr'=>['title'=>$this->getTitle($data)]
					];
		}
		// $array = [
		// 		['id'=>1,'text'=>'a','parent'=>'#'],
		// 		['id'=>2,'parent'=>1,'text'=>'ac','children'=>true],
		// 		['id'=>3,'text'=>'c','parent'=>'#']
		// 	];

		echo json_encode($array);
		exit;
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

		$str = "
				<table  style='width:100%;' width:'100%'>
				  <tr>
				  	<th class='text-align:center;'>Name: ".$model['name'].' ('.$model['user'].')'."</th>
				  </tr>
				  <tr>
				  	<th class='text-align:center;'>Intro: ".$model['introducer']."</th>
				  </tr>
				  <tr><td><p style='padding:0px;margin:5px;color:white;'></p></td></tr>
				  <tr>
				  	<td>
				    <table  style='width:100%'>
				    	<tr>
				    		<th >Reg. Date<br/>". date("d M Y", strtotime($model['created_at']))."</th>
				    		<th >Act. Date<br/>".$greened_on_date."</th>
				    	</tr>
				    </table>
				    </td>
				  </tr>
				  <tr><td><p style='padding:0px;margin:5px;color:white;'></p></td></tr>
				  <tr>
				  	<td style='text-align:center;'>Package Detail:".$kit_item. "<br/> SV:( ".$model['sv']." ) BV:( ".$model['bv']." ) </td>
				  </tr>
				  <tr><td><p style='padding:0px;margin:5px;color:white;'></p></td></tr>
				  <tr>
				  	<td>
				    <table  style='width:100%'>
				    	<tr>
				    		<td style='text-align:left;'>Total Left SV<br/>".$model['total_left_sv']."</td>
				    		<td style='text-align:right;'>Total Right SV<br/>".$model['total_right_sv']."</td>
				    	</tr>
				    </table>
				    </td>
				  </tr>
				  <tr><td><p style='padding:0px;margin:5px;color:white;'></p></td></tr>
				  <tr>
				  	<td>
				    <table  style='width:100%'>
				    	<tr>
				    		<td style='text-align:left;'>Month Self BV<br/>".$model['month_self_bv']."</td>
				    		<td style='text-align:right;'>Accumulated BV<br/>".$model['total_month_bv']."</td>
				    	</tr>
				    </table>
				    </td>
				  </tr>
					<tr><td><p style='padding:0px;margin:5px;color:white;'></p></td></tr>				  
				  <tr>
				  	<td>
				    <table  style='width:100%'>
				    	<tr>
				    		<th style='text-align:left;'>Total Team Left<br/>".$model->newInstance()->addCondition('path','like',$model['path'].'A%')->count()->getOne()."</th>
				    		<th style='text-align:right;'>Total Team Right<br/>".$model->newInstance()->addCondition('path','like',$model['path'].'B%')->count()->getOne()."</th>
				    	</tr>
				    </table>
				    </td>
				  </tr>
				</table>";		
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

	function getTitle_old($model){
		if($model['greened_on'] !== null)
			$greened_on_date = date("d M Y", strtotime($model['greened_on']));
		else
			$greened_on_date = "--/---/----";
		$str=  
				$model['name']. " [".$model['user']."]".
				"<br/>Jn: ". date("d M Y", strtotime($model['created_at'])). 
				"<br/>Gr: ". $greened_on_date. 
				"<br/>Kit: ". ($model['kit_item']?:'') ." SV(".$model['sv'].")"."BV(".$model['bv'].")".
				"<br/>Intro: ". $model['introducer'] .
				"<br/>Month Self BV: ". $model['month_self_bv'].
				"<br/>Commulative Month BV: ". $model['total_month_bv'].
				"<br/>Rank: ". $model['current_rank'].
				"<br/>Slab Percentage: ". $model->ref('current_rank_id')->get('slab_percentage')
				// "<br/>Slab Percentage: ". $model['temp']
				;
				
		$str= str_replace("'", "\'", $str);
		$str= str_replace("\n", "", $str);
		return $str;
	}

}