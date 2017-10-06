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

		$str = "<table class='tooltipdetail-generation'  style='width:100%;text-align:left;'>
					<tr>
				  		<th valign='top' style='width:30%;'>Name</th>
				  		<th> : ".$model['name'].' ('.$model['user'].')'."</th>
					</tr>
					<tr>
				  		<th valign='top'>Reg Date</th>
				  		<th> : ".date("d M Y", strtotime($model['created_at']))."</th>
				  	</tr>
				  	<tr>
				  		<th valign='top'>Act Date</th>
				  		<th> : ".$greened_on_date."</th>
				  	</tr>
				  	<tr>
				  		<th valign='top'>Package</th>
				  		<th>:".$kit_item."<br/>:SV:(".$model['sv'].") BV:(".$model['bv'].")</th>
				  	</tr>
				  	<tr>
				  		<th valign='top'>Intro</th>
				  		<th>:".$model['introducer']."</th>
				  	</tr>
					</table>
					<br/>
					<table style='width:100%;text-align:left;' class='tooltipdetail-generation'>
						<tr>
				    		<th valign='top' style='text-align:left;width:50%;'>Total Team (Left)<br/>".$model->newInstance()->addCondition('path','like',$model['path'].'A%')->count()->getOne()."</th>
				    		<th style='text-align:right;width:50%;'>Total Team (Right)<br/>".$model->newInstance()->addCondition('path','like',$model['path'].'B%')->count()->getOne()."</th>
					    </tr>
					    <tr>
					    	<th><br/></th>
					    	<th><br/></th>
					    </tr>
						<tr>
							<th valign='top' style='text-align:left !important;width:50%;'>Total SV (Left)<br/>".$model['total_left_sv']."</th>
					    	<th style='text-align:right !important;width:50%;'>Total SV (Right)<br/>".$model['total_right_sv']."</th>
						</tr>
						<tr>
					    	<th><br/></th>
					    	<th><br/></th>
					    </tr>
					    <tr>
					    	<th valign='top' style='text-align:left;width:50%;'>Month Self BV<br/>".$model['month_self_bv']."</th>
					    	<th style='text-align:right;width:50%;'>Accumulated BV<br/>".$model['total_month_bv']."</th>
					    </tr>
					</table>
				  ";

		$str = str_replace( "\'","'", $str);
		$str = str_replace("\n", "", $str);
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