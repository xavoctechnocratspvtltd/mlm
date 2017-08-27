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
						'text'=>$data['first_name'],
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