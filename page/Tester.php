<?php


namespace xavoc\mlm;


class page_Tester extends \xepan\base\Page_Tester{


	function init(){
		ini_set('memory_limit', '2048M');
        set_time_limit(0);
        gc_enable();
		parent::init();
		
	}

	function setDateTime($date){
		$this->on_date = $date;
		$this->app->ispnow = $date;
		$this->app->isptoday = date('Y-m-d',strtotime($date));
	}

	function _($data){
		return $this->app->human2byte($data);
	}

	function filterColumns($data,$fields){
		foreach ($data as &$datum) {
			foreach ($datum as $field => $value) {
				if(!in_array($field, $fields)) unset($datum[$field]);
			}
		}
		return $data;
	}

	/*
	$data = [
		'0a/ram/unique_key'=>['sponsor'=>'company/unique_key','introducer'=>'company/unique_key','on'=>'date','kit'=>'kit name (optional)'],
		'kit-0a'=>'kit name',
		'green-0a'=>'date',
		'repurchase-0a'=>'total bv',
		'closing'=>date
	]
	*/

	function process($data,$result='dist'){
		$this->resetData();
		$root_id = $this->add('xavoc\mlm\Model_Distributor')->loadRoot()->get('id');
		
		$distributor_id_mapping=['0'=>$root_id,'company'=>$root_id];

		foreach ($data as $key => $value) {
			if(strpos($key, 'kit')===0){
				$action = 'kitpurchase';
				$dist_id=(explode('-',$key))[1];
			}elseif(strpos($key, 'green')===0){
				$action = 'green';
				$dist_id=(explode('-', $key))[1];
			}elseif(strpos($key, 'repurchase')===0){
				$action = 'repurchase';
				$dist_id=explode('-',$key)[1];
			}elseif(strpos($key, 'closing')===0){
				$action = 'closing';
				$dist_id=null;
			}else{
				$action = 'joining';
				$dist_id = null;
			}

			switch ($action) {
				case 'joining':
					$dist = $this->add('xavoc\mlm\Model_Distributor');
					$data = [
								'first_name'=>$key,
								'introducer'=>$distributor_id_mapping[$value['introducer']],
								'created_at'=>$value['on'],
								'side'=>$value['side']
							];
					$dist->register($data);

					if(isset($value['kit'])) $dist->purchaseKit($this->add('xavoc\mlm\Model_Kit')->tryLoadBy('name',$value['kit']));
					$distributor_id_mapping[$key]= $dist->id;
					break;
				case 'kitpurchase':
					$dist = $this->add('xavoc\mlm\Model_Distributor')->load($distributor_id_mapping[$dist_id]);
					$dist->purchaseKit($this->add('xavoc\mlm\Model_Kit')->tryLoadBy('name',$value));
					break;
				case 'green':
					$dist = $this->add('xavoc\mlm\Model_Distributor')->load($distributor_id_mapping[$dist_id]);
					$dist->markGreen($value);
					break;
				case 'repurchase':
					$dist = $this->add('xavoc\mlm\Model_Distributor')->load($distributor_id_mapping[$dist_id]);
					$dist->repurchase($value);
					break;
				case 'closing':
					$this->add('xavoc\mlm\Model_Closing')->doClosing($value);
					break;
				
				default:
					# code...
					break;
			}
		}



		$result = strtolower(substr($result, 0,4));
		if($result == 'dist'){
			$r= $this->add('xavoc\mlm\Model_Distributor')->addCondition('id',$distributor_id_mapping);
			return $this->resultDistributor($r,$distributor_id_mapping);
		}
		else
			return $this->resultClosing($r,$distributor_id_mapping);

	}

	// function result($r,$table='dist'){
	// 	$table = strtolower(substr($table, 0,4));
	// 	if($table == 'dist')
	// 		return $this->resultDistributor($r);
	// 	else
	// 		return $this->resultClosing($r);

	// 	return ['data_limit_row'=>$r['result']['data_limit_row'],'bw_limit_row'=>$r['result']['bw_limit_row'],'dl'=>$r['result']['dl_limit'],'ul'=>$r['result']['ul_limit'],'data_consumed'=>$r['result']['data_consumed'],'access'=>$r['access'],'coa'=>$r['result']['coa'],'time_limit'=>$r['result']['time_limit'],'time_consumed'=>$r['result']['time_consumed']];
	// }

	function resultDistributor($r,$distributor_id_mapping){
		$array=[];
		foreach ($r as $row) {
			$array[]=[
				'name'=>$r['first_name'],
				'path'=>$r['path'],
				'sponsor'=> array_search($r['sponsor_id'],$distributor_id_mapping),
				'introducer'=> array_search($r['introducer_id'],$distributor_id_mapping),
				'kit'=>$r['kit_item'],
				'introAmount'=>$r['weekly_intros_amount'],
				'leftSv' => $r['weekly_left_sv'],
				'rightSv' => $r['weekly_right_sv'],
				'leftDP'=>$r['monthly_left_dp_mrp_diff'],
				'rightDP'=>$r['monthly_right_dp_mrp_diff'],
				'totalPairs'=>$r['total_pairs'],
				'carriedAmount'=>$r['carried_amount'],
				'joinedOn'=>$r['created_at'],
				'greenedOn'=>$r['greened_on'],
				];
		}
		return $array;
	}

	function resultClosing($r){

	}

	function resetData(){
		$this->add('xavoc\mlm\Model_Closing')->deleteAll();
		$this->add('xavoc\mlm\Model_Distributor')->setupCompany();
	}
	

}