<?php


namespace xavoc\ispmanager;


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

	function process($data){
		$root_id = $this->add('xavoc\mlm\Model_Distributor')->loadRoot()->get('id');
		
		$distributor_id_mapping=['0'=>$root_id,'company'=>$root_id];

		foreach ($data as $key => $value) {
			if(strpos($key, 'kit')===0){
				$action = 'kitpurchase';
				$dist_id=explode($key, '-')[1];
			}elseif(strpos($key, 'green')===0){
				$action = 'green';
				$dist_id=explode($key, '-')[1];
			}elseif(strpos($key, 'repurchase')===0){
				$action = 'repurchase';
				$dist_id=explode($key, '-')[1];
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
					$dist('')
					break;
				case 'kitpurchase':
					# code...
					break;
				case 'green':
					# code...
					break;
				case 'repurchase':
					# code...
					break;
				case 'closing':
					# code...
					break;
				
				default:
					# code...
					break;
			}
		}

	}

	function result($r){
		return ['data_limit_row'=>$r['result']['data_limit_row'],'bw_limit_row'=>$r['result']['bw_limit_row'],'dl'=>$r['result']['dl_limit'],'ul'=>$r['result']['ul_limit'],'data_consumed'=>$r['result']['data_consumed'],'access'=>$r['access'],'coa'=>$r['result']['coa'],'time_limit'=>$r['result']['time_limit'],'time_consumed'=>$r['result']['time_consumed']];
	}
	

}