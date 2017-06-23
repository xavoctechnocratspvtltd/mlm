<?php


namespace xavoc\mlm;

class page_importer extends \xepan\base\Page {
	public $title= "Old Data Importer";

	function init(){
		parent::init();

		set_time_limit(0);



		$form = $this->add('Form');
		$form->addField('Number','import_record');
		$form->addField('Upload','csv_file')->setModel('xepan\filestore\File');
		$form->addSubmit('Import')->addClass('btn btn-primary');
		
		$view = $this->add('View')->addClass('alert');
		if($_GET['total_dist'] OR $_GET['dis_having_not_kit']){
			$msg = '<div class="alert bg bg-success">Total Distributor Import = '.$_GET['total_dist'].'</div>';
			$msg .= '<div class="alert bg bg-danger">Distributor having no kit id = '.$_GET['dis_having_not_kit'].'</div>';
			
			if( is_array($_GET['unused_data'])&& count($_GET['unused_data']) > 0){
				$msg .= "Distributor not added = ".count($_GET['unused_data']);
				foreach ($_GET['unused_data'] as $key => $data) {
					$msg .= " Distributor = ".$data['first_name']." Member_PrimaryKey".$data['Member_PrimaryKey']."<br/>";
				}
			}
			// $mapping = $_GET['mapping']?:[];
			// $mapping_str = "";
			// if(is_array($mapping)){
			// 	foreach ($mapping as $old_d_id => $new_d_id) {
			// 		$mapping_str .=" Old Id = ".$old_d_id." new id=".$new_d_id."<br/>";
			// 	}
			// }else{
			// 	$mapping_str .= $_GET['mapping'];
			// }
			// $msg .= $mapping_str;
			$view->setHTML($msg);
		}

		if($form->isSubmitted()){

			$file_m = $this->add('xepan\filestore\Model_File')->load($form['csv_file']);
			$path = $file_m->getPath();


			$importer = new \xepan\base\CSVImporter($path,true,',');
			$csv_data = $importer->get();
			
			// try{

			// 	$this->api->db->beginTransaction();

				$this->add('xavoc\mlm\Controller_Setup',['remove_everything'=>true,'importing_old_data'=>true]);

				// [old_dis_id => new_dis_id,old_dis_id => new_dis_id]
				$root_ds = $this->add('xavoc\mlm\Model_Distributor')->loadRoot();
				$all_package = [];
				$dis_having_not_kit = [];			
				$kits = $this->add('xavoc\mlm\Model_Kit');
				foreach ($kits as $key => $kit) {
					$all_package[$kit['sku']] = [
											'id'=>$kit['id'],
											'bv'=>$kit['bv'],
											'sv'=>$kit['sv'],
											'pv'=>$kit['pv'],
											'capping'=>$kit['capping']
										];
				}

				$dis_id_mapping = [1=>$root_ds->id];
				// old_plan_name => new package_code
				$package_mapping = [
								// 'Registration'=>0,
								'1000'=>'Package A1',
								'7200'=>'Package C1',
								'24000'=>'Package D1',
								'120000'=>'Package D1',
								'300000'=>'Package D1',
								'480000'=>'Package D1'
							];
				$unused_data = [];
				// throw new \Exception("Error Processing Request", 1);
				$count = 0;
				foreach ($csv_data as $key => $old_dis) {

					// if($form['import_record'] > 0 && $count > $form['import_record']) break;

					$data = [];
					$data['sponsor_id'] =  $dis_id_mapping[$old_dis['Upline_PrimaryKey']];
					$data['introducer_id'] =  $dis_id_mapping[$old_dis['sponsorid_Key']];
					$data['first_name'] = $old_dis['fname'];
					$data['address'] = $old_dis['address'];

					$data['city'] = $old_dis['city'];

					$country = $this->add('xepan\base\Model_Country');
					$country->addCondition('name', ucwords($data['country']));
					$country->tryLoadAny();
					if($country->loaded())
						$data['country_id'] = $country->id;
					$country->destroy();
					
					$state = $this->add('xepan\base\Model_State');
					$state->addCondition('name', ucwords($data['state']));
					$state->tryLoadAny();
					if($state->loaded())
						$data['state_id'] = $state->id;
					$state->destroy();

					$data['pin_code'] = $old_dis['pincode'];

					$data['mobile_number'] = $old_dis['mobileno'];
					$data['email'] = $old_dis['email'];

					$data['created_at'] = date('Y-m-d H:i:s', strtotime($old_dis['joiningdate']));

					$data['d_bank_name'] = $old_dis['bankname'];
					$data['d_account_number'] = $old_dis['accountno'];
					$data['d_bank_ifsc_code'] = $old_dis['ifsccode'];
					$data['pan_no'] = $old_dis['panno'];

					$data['username'] = $old_dis['Member_Username'];
					$data['password'] = $old_dis['password'];

					if($old_dis['leftpoint'] > $old_dis['rightpoint']){
						$old_dis['leftpoint'] = $old_dis['leftpoint'] - $old_dis['rightpoint'];
						$old_dis['rightpoint']= 0;
					}else{
						$old_dis['rightpoint'] = $old_dis['rightpoint'] - $old_dis['leftpoint'];
						$old_dis['leftpoint']= 0;
					}

					$data['day_left_sv'] = $data['total_left_sv'] = $old_dis['leftpoint'];
					$data['day_right_sv'] = $data['total_right_sv'] = $old_dis['rightpoint'];

					if($old_dis['Position']== 'L')
						$data['side'] =  'A';
					else
						$data['side'] =  'B';

						$kit_code = $package_mapping[trim($old_dis['planname'])];

						
						$before_1st_june = false;
						$first_june = strtotime('2017-06-1 00:00:00');
						$created_at = strtotime($data['created_at']);

						if(isset($all_package[$kit_code]) && $all_package[$kit_code]['id'] && ($first_june > $created_at) ){
							$kit_array = $all_package[$kit_code];
							$kit_id =  $kit_array['id'];

							$data['kit_item_id'] = $kit_id;
							$data['sv'] = $kit_array['sv'];
							$data['pv'] = $kit_array['pv'];
							$data['bv'] = $kit_array['bv'];
							$data['capping'] = $kit_array['capping'];
							$data['status'] = "Green";

							$data['greened_on'] = date('Y-m-d H:i:s', strtotime($old_dis['topupeddate']));
							$data['status'] = "Green";
							$before_1st_june = true;
						}else{
							$data['status'] = "Red";
							$dis_having_not_kit[] = $distributor->id;
						}



					// try{
						$distributor = $this->add('xavoc\mlm\Model_Distributor');
						$distributor->register($data);
						if($before_1st_june){
							$distributor->purchaseKit($kit_id);
							$distributor->markGreen($data['greened_on']);
						}

						if(!isset($dis_id_mapping[$old_dis['Member_PrimaryKey']]))
							$dis_id_mapping[$old_dis['Member_PrimaryKey']] = $distributor->id;

					// }catch(\Exception $e){
					// 	throw $e;
						
						// $unused_data[] = $data;
					// }
					$count++;
					$distributor->destroy();

				}

				// $this->api->db->commit();
			// }catch(\Exception $e){
			// 	$this->api->db->rollback();
			// 	throw new \Exception($e->getMessage());
			// }

			// echo "<pre>";
			// print_r($dis_id_mapping);
			// echo "</pre>";
			$form->js(null,$view->js()->reload(['total_dist'=>$count,'dis_having_not_kit'=>count($dis_having_not_kit),'mapping'=>$dis_id_mapping,'unused_data'=>$unused_data]))->univ()->successMessage('done')->execute();
		}
	}

}