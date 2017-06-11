<?php


namespace xavoc\mlm;


class page_Tester extends \xepan\base\Page_Tester{
	public $distributor_id_mapping=null;
	public $model_name_mapping = [
						'd'=>'Distributor',
						'gb'=>'GenerationBusiness',
						'gis'=>'GenerationIncomeSlab',
						'c'=>'Closing',
						'p'=>'Payout',
						'lbs'=>'LoyaltiBonusSlab',
						'rpbs'=>'RePurchaseBonusSlab'
					];


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
		'0a/ram/unique_key'=>['sponsor'=>'company/unique_key','introducer'=>'company/unique_key','on'=>'date','kit'=>'kit name (optional)','green'=>'green_date'],
		'kit-0a'=>'kit name',
		'green-0a'=>'date',
		'repurchase-0a'=>'total bv',
		'closing-daily'=>date
	]
	*/

	function process($data,$response_key,$result='dist'){
		try{
			$this->api->db->beginTransaction();
				
			// $this->resetData();
			$root_id = $this->add('xavoc\mlm\Model_Distributor')->loadRoot()->get('id');
			
			if(!$this->distributor_id_mapping)
				$this->distributor_id_mapping = ['0'=>$root_id,'company'=>$root_id];

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
					$closing_type=explode('-',$key)[1];
				}else{
					$action = 'joining';
					$dist_id = null;
				}

				switch ($action) {
					case 'joining':
						$dist = $this->add('xavoc\mlm\Model_Distributor');
						$data = [
									'first_name'=>$key,
									'introducer_id'=>$this->distributor_id_mapping[$value['introducer']]?:$this->add('xavoc\mlm\Model_Distributor')->loadBy('user',$value['introducer'])->get('id'),
									'created_at'=>$value['on'],
									'side'=>$value['side']
								];
						$dist->register($data);

						if(isset($value['kit'])) $dist->purchaseKit($this->add('xavoc\mlm\Model_Kit')->loadBy('sku',$value['kit']));
						$this->distributor_id_mapping[$key]= $dist->id;
						if(isset($value['green'])) $dist->markGreen($value['on']);
						break;
					case 'kitpurchase':
						$dist = $this->add('xavoc\mlm\Model_Distributor')->load($this->distributor_id_mapping[$dist_id]);
						$dist->purchaseKit($this->add('xavoc\mlm\Model_Kit')->loadBy('sku',$value));
						break;
					case 'green':
						$dist = $this->add('xavoc\mlm\Model_Distributor')->load($this->distributor_id_mapping[$dist_id]);
						$dist->markGreen($value);
						break;
					case 'repurchase':
						$dist = $this->add('xavoc\mlm\Model_Distributor')->load($this->distributor_id_mapping[$dist_id]);
						$dist->repurchase($value);
						break;
					case 'closing':
						if($closing_type !=='daily'){
							$this->add('xavoc\mlm\Model_Closing')
								->set('on_date',$value)
								->set('type',ucwords($closing_type).'Closing')
								->set('calculate_loyalty',false)
								->save()
								;
								// ->doClosing($closing_type,$value);
						}else{
							$this->add('xavoc\mlm\Model_Closing')
								->doClosing($closing_type,$value);
						}
						break;
					
					default:
						# code...
						break;
				}
			}

			$this->api->db->commit();

			// check this->proper_response and make an array with values from db in format
			$response_data = $this->proper_responses[$response_key];
			// echo "<pre>";
			// print_r($required_data);
			// echo "</pre>";
			// die();
			//required_data = Array
			// 	(
			// 	    [0] => Array
			// 	        (
			// 	            [Ram] => Array
			// 	                (
			// 	                    [d.path] => 0A
			// 	                    [d.month_self_bv] => 120
			// 	                    [p.carried_amount] => 1250
			//		[1] => Array()
			// )))
			$result = [];

			foreach ($response_data as $key => $values) {
					$result[$key] = [];
				foreach ($values as $name => $required_data) {
					$result[$key][$name] = [];
					$distributor_model = $this->add('xavoc\mlm\Model_Distributor')
											->loadBy('first_name',$name);

					foreach ($required_data as $model_with_field => $value) {

						$exp_array = explode(".", $model_with_field);
						$model_name = $this->model_name_mapping[$exp_array[0]];
						$required_field_data = $exp_array[1];
						
						// echo "<pre>";
						// print_r($required_field_data);
						// // print_r($exp_array);
						// echo "</pre>";
						// die();

						if(!in_array($model_name, ['Distributor'])){
							$model = $this->add('xavoc\mlm\Model_'.$model_name);
							$model->addCondition('distributor_id',$distributor_model->id);
							$model->setOrder('id','desc');
							$model->tryLoadAny();
						}else{
							$model = $distributor_model;
						}

						if($model->loaded())
							$result[$key][$name][$model_with_field] = $model[$required_field_data];
						else
							$result[$key][$name][$model_with_field] = 0;
					}
				}
			}

			// echo "<pre>";
			// print_r($result);
			// echo "</pre>";
			// die();
			return $result; 
			// that is given in proper_response_array
			
			// $result = strtolower(substr($result, 0,4));
			// if($result == 'dist'){
			// 	$r= $this->add('xavoc\mlm\Model_Distributor')->addCondition('id',$distributor_id_mapping);
			// 	return $this->resultDistributor($r,$distributor_id_mapping);
			// }
			// else
			// 	return $this->resultClosing($r,$distributor_id_mapping);
		}catch(\Exception $e){
			$this->api->db->rollback();
			throw $e;
		}
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
				'joinedOn'=>date('Y-m-d',strtotime($r['created_at'])),
				'greenedOn'=>date('Y-m-d',strtotime($r['greened_on'])),
				];
		}
		return $array;
	}

	function resultClosing($r){

	}

	function resetData($remove_everything=false){
		$this->add('xavoc\mlm\Controller_Setup',['remove_everything'=>$remove_everything]);
	}
	

}