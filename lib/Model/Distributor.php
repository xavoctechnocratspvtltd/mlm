<?php

namespace xavoc\mlm;


class Model_Distributor extends \xepan\commerce\Model_Customer {

	public $status = ['Active','InActive'];
	public $actions = [
				'Active'=>['view','edit','delete'],
				'InActive'=>['view','edit','delete','active']
				];
	public $acl_type= "ispmanager_distributor";

	function init(){
		parent::init();

		$dist_j = $this->join('mlm_distributor.customer_id');

		$dist_j->hasOne('xavoc\mlm\Sponsor','sponsor_id')->display(['form'=>'xepan\base\Basic']);
		$dist_j->hasOne('xavoc\mlm\Introducer','introducer_id')->display(['form'=>'xepan\base\Basic']);

		$dist_j->hasOne('xavoc\mlm\Left','left_id')->display(['form'=>'xepan\base\DropDownNormal']);
		$dist_j->hasOne('xavoc\mlm\Right','right_id')->display(['form'=>'xepan\base\DropDownNormal']);

		$dist_j->addField('path')->type('text');
		$dist_j->addField('introducer_path')->type('text');
		$dist_j->addField('side')->enum(['A','B'])->display(['form'=>'xepan\base\DropDownNormal']);

		$dist_j->hasOne('xavoc\mlm\Kit','kit_item_id')->defaultValue(null)->caption('Startup Package');
		$dist_j->addField('capping')->type('int')->system(true)->defaultValue(0);
		$dist_j->addField('pv')->type('int')->system(true)->defaultValue(0);
		$dist_j->addField('bv')->type('int')->system(true)->defaultValue(0);
		$dist_j->addField('sv')->type('int')->system(true)->defaultValue(0);
		$dist_j->addField('email');
		$dist_j->addField('mobile_number');
		$dist_j->addField('dob')->type('date')->caption('Date of Birth');
		// $dist_j->addField('IFCS_Code')->mandatory("IFSC Code is required")->display(array('form'=>'xavoc\mlm\AlphaNumeric'))->caption('IFSC Code');
		// $dist_j->addField('branch_name')->caption('Branch')->mandatory("Branch name is required")->display(array('form'=>'\xavoc\mlm\Alpha'));//->system(true);
		$dist_j->addField('kyc_no')->mandatory("KYC no is required")->caption('KYC no.');
		// $dist_j->add('xepan\filestore\Field_Image','kyc_id')->caption('KYC form');
		// $dist_j->add('xepan\filestore\Field_Image','address_proof_id')->caption('Address proof');
		$dist_j->addField('nominee_name')->mandatory("Nominee name is required")->display(array('form'=>'xavoc\mlm\Alpha'))->caption('Nominee name');
		$dist_j->addField('relation_with_nominee')->enum(['Mother','Father','Wife','Other'])->mandatory("Relation with nominee is required")->caption('Relation with Nominee');//->system(true);
		$dist_j->addField('nominee_email')->caption('Nominee email')->display(array('form'=>'xavoc\mlm\Email'));//->system(true);
		$dist_j->addField('nominee_age')->mandatory("Nominee age is required")->display(array('form'=>'xavoc\mlm\Range'))->caption("Nominee age");


		// weekly session
		$dist_j->addField('weekly_intros_amount')->type('money')->defaultValue(0);
		$dist_j->addField('total_intros_amount')->type('money')->defaultValue(0);

		$dist_j->addField('day_left_sv')->type('int')->defaultValue(0);
		$dist_j->addField('day_right_sv')->type('int')->defaultValue(0);
		$dist_j->addField('day_pairs')->type('int')->defaultValue(0);
		$dist_j->addField('week_pairs')->type('int')->defaultValue(0);

		$dist_j->addField('total_left_sv')->type('int')->defaultValue(0);
		$dist_j->addField('total_right_sv')->type('int')->defaultValue(0);

		// monthly session
		$dist_j->addField('monthly_left_dp_mrp_diff')->type('int')->defaultValue(0);
		$dist_j->addField('monthly_right_dp_mrp_diff')->type('int')->defaultValue(0);
		
		// ==== Moved to payout to maintain history as much as possible ====
		// $dist_j->addField('rank');
		// $dist_j->addField('generation_a_business')->type('int');
		// $dist_j->addField('generation_b_business')->type('int');
		// $dist_j->addField('re_purchase_incomce_gross')->type('int');
		// $dist_j->addField('re_purchase_incomce')->type('int');
		
		$dist_j->addField('total_pairs')->type('int')->defaultValue(0);
		$dist_j->addField('carried_amount')->type('money')->defaultValue(0)->caption('Carried amount');

		$dist_j->addField('greened_on')->type('datetime')->defaultValue(null)->caption('Qualified date');
		$dist_j->addField('ansestors_updated')->type('boolean')->defaultValue(false)->system(true);
		
		$dist_j->addField('temp')->type('number')->system(true);

		// payment mode fields
		// for online payment
		$dist_j->addField('payment_mode')->enum(['online','cash','cheque','dd','deposite_in_franchies']);
		$dist_j->addField('transaction_reference');
		$dist_j->addField('transaction_detail');
		// cash field
		// cheque field or dd
		$dist_j->addField('bank_name');
		$dist_j->addField('bank_ifsc_code');
		$dist_j->addField('cheque_number');
		$dist_j->addField('dd_number');
		$dist_j->addField('cheque_date');
		$dist_j->addField('dd_date');
		
		$this->hasMany('xavoc\mlm\GenerationBusiness','distributor_id');
		$this->hasMany('xavoc\mlm\Attachment','distributor_id');
		
		$this->addHook('beforeSave',array($this,'beforeSaveDistributor'));
		$this->addHook('afterSave',array($this,'afterSaveDistributor'));
		$this->addHook('beforeDelete',array($this,'beforeDeleteDistributor'));
		$this->addHook('afterInsert',$this);

		$this->add('Controller_Validator');
		// $this->is(array(
		// 					'username|to_trim|unique',
		// 					'password|to_trim',
		// 					// 're_password|to_trim',
		// 				)
		// 		);

		$this->setOrder('greened_on','desc');
		$this->getElement('created_at')->caption('Joining date');

		/*
			Need a few more fields based on plan and calculations
			
			Self,
	
			Left & Right		
			Small-Session : Day, Week, Fortnight
			Session is Default 'Main Closing' to closing duration
			Big-Session : Month, Quarter, Yearly
	

			BV, PV, SV,


		*/
		
		
	}

	function beforeSaveDistributor(){
		if(!$this->loaded()){
			// Its New Entry
			$dist= $this->add('xavoc\mlm\Model_Distributor')->loadLoggedIn();
			if(!($dist OR $this->api->auth->model->isSuperUser())){
				throw $this->exception('You do not have rights to add distributor');
			}

			if($introducer = $this->introducer()){
				$this['introduced_path'] = $introducer->path() . $this['side'];
			}

			$this['sponsor_id'] = $this->findSponsor($introducer, $this['side'])->get('id');

			if($sponsor = $this->sponsor()){
				if($sponsor[($this['side']=='A'?'left':'right').'_id']){
					throw $this->exception('Leg Already Filled','ValidityCheck')->setField('Leg');
				}
				$this['path'] = $sponsor->path() . $this['side'];
				$this->memorize('leg',$this['side']);
				$this->memorize('raw_password',$this['password']);
			}
		}
	}

	function findSponsor($introducer, $side){
		$intro_path_length = strlen($introducer['path']);
		$sponsor = $this->add('xavoc\mlm\Model_Distributor');
		$sponsor->addExpression('next_path')->set($sponsor->dsql()->expr("RIGHT(path,LENGTH(path)-$intro_path_length)"));
		$sponsor->addExpression('path_length')->set('LENGTH(path)');
		$sponsor->addCondition('path','like',$introducer['path'].'%');
		$sponsor->addCondition('next_path','not like',"%".($side=='A'?'B':'A')."%");
		$sponsor->_dsql()->order('path_length desc');
		$sponsor->tryLoadAny();
		return $sponsor;
	}

	function afterSaveDistributor(){
		if($leg = $this->recall('leg',false)){
			if($sponsor = $this->sponsor()){
				$sponsor[($leg=='A'?'left':'right').'_id'] = $this->id;
				try{
					$sponsor->save();
				}catch(\Exception $e){
					throw $e;
					
				}
			}
			// if($this['greened_on']){
			// 	$kit=$this->kit();
			// 	$this->updateAnsestors($kit->getPV(),$kit->getBV());
			// 	$introducer = $this->introducer();
			// 	$introducer->addSessionIntro($kit->getIntro());
			// }
			
			// $this->welcomeDistributor();

			// $m_no=$this['mobile_number'];
		
    		// $message= "Thank you for joining Nebula! We have send your login Credentials on your registered email ID. Please Call us \n on 18004192299 for any assistance. Happy Networking!\nBest Regards,\nNebula Team - Reach Beyond";
		
			// $this->add('Controller_Sms')->sendMessage($m_no,$message);

			if($this->introducer()){
				$bv_table = $this->add('xavoc\mlm\Model_GenerationBusiness');
				$bv_table->addCondition('introduced_id',$this->id);
				$bv_table->addCondition('distributor_id',$this['introducer_id']);
				$bv_table->tryLoadAny();
				$bv_table['introduced_path'] = $this['path'];
				$bv_table->save();
			}


			$this->forget('leg');

			// $this->api->db->dsql()->table('xshop_memberdetails')->where('id',$this['customer_id'])->set('users_id',$this['user_id'])->update();
		}
	}

	function beforeDeleteDistributor(){
		$user_id = $this['user_id'];
		if($user_id){
			$this->addHook('afterDelete',function($m)use($user_id){
				$this->add('xepan\base\Model_User')->tryLoad($user_id)->tryDelete();
			});
		}

		$this->ref('xavoc\mlm\GenerationBusiness')->deleteAll();

	}

	function afterInsert($obj){
		
	}

	function purchaseKit($kit){
		$this['kit_item_id']= $kit->id;
		$this->save();
	}

	function markGreen($on_date=null){
		if(!$on_date) $on_date =  $this->app->now;
		
		$this['greened_on'] = $on_date;

		$kit = $this->kit();
		if(!$kit) throw new \Exception("Cannot mark green without kit", 1);
		
		$this['capping'] = $kit['capping'];
		$this['pv'] = $kit['pv'];
		$this['bv'] = $kit['bv'];
		$this['sv'] = $kit['sv'];

		$this->save();
		$this->updateAnsestorsSV($this['sv']);
		if($introducer  = $this->introducer()) $introducer->addSessionIntro($kit['introducer_income']);
	}

	function repurchase($bv){

	}

	function updateAnsestorsSV($sv_points){
		$path = $this['path'];
		$q="
				UPDATE mlm_distributor d
				Inner Join 
				(SELECT 
					id,
					path,
					LEFT('$path',LENGTH(path)) desired,
					MID('$path',LENGTH(path)+1,1) next_char
				 FROM mlm_distributor
				 HAVING
				 next_char = 'A' AND desired=path
				 ) lefts on lefts.id = d.id
				SET
					day_left_sv = day_left_sv + $sv_points,
					total_left_sv = total_left_sv + $sv_points
		";
		$this->api->db->dsql($this->api->db->dsql()->expr($q))->execute();

		$q="
				UPDATE mlm_distributor d
				Inner Join 
				(SELECT 
					id,
					path,
					LEFT('$path',LENGTH(path)) desired,
					MID('$path',LENGTH(path)+1,1) next_char
				 FROM mlm_distributor 
				 HAVING
				 next_char = 'B' AND desired=path
				 ) rights on rights.id = d.id
				SET
					day_right_sv = day_right_sv + $sv_points,
					total_right_sv = total_right_sv + $sv_points
		";

		$this->api->db->dsql($this->api->db->dsql()->expr($q))->execute();
	}

	function updateAnsestorsBV($bv_points){
		// In introducer table
		$path = $this['path'];
		$q="
				UPDATE mlm_generation_business gt
				SET
					bv_sum = bv_sum + $bv_points
				WHERE 
					LEFT('$path',LENGTH(path)) = path;
		";
		$this->api->db->dsql($this->api->db->dsql()->expr($q))->execute();

	}

	function addSessionIntro($intro_amount){
		$this['weekly_intros_amount'] = $this['weekly_intros_amount'] + $intro_amount;
		$this['total_intros_amount'] = $this['total_intros_amount'] + $intro_amount;
		$this->save();
	}

	function sponsor(){
		if($this['sponsor_id'])
			return $this->ref('sponsor_id');
		return false;
	}

	function introducer(){
		if($this['introducer_id'])
			return $this->ref('introducer_id');
		return false;
	}

	function path(){
		return $this['path'];
	}

	function kit(){
		if($this['kit_item_id'])
			return $this->ref('kit_item_id');
		return false;
	}

	function isInDown($downline_distributor){
		
		$down_path = $downline_distributor['path'];
		$my_path =$this['path'];

		$in_down = strpos($down_path, $my_path) !== false;
		return $in_down;
	}

	function loadRoot(){
		return $this->loadBy('path','0');	
	}

	function notifyViaEmail($subject, $email_body){
		$email = $this['email'];
		if(!$email) return;
		$tm=$this->add( 'TMail_Transport_PHPMailer' );	
		try{
			$tm->send($email, $email,$subject, $email_body);
		}catch( \phpmailerException $e ) {
			$this->js(true)->univ()->errorMessage($e->getMessage());
		}catch( \Exception $e ) {
			throw $e;
		}
	}


	function register($data){
		// throw new \Exception("Error Processing Request", 1);
		foreach ($data as $field => $value) {
			$this[$field] = $value;
		}

		$user = $this->add('xepan\base\Model_User');

		$this->add('BasicAuth')
				->usePasswordEncryption('md5')
				->addEncryptionHook($user);
		
		$user->addCondition('username',(isset($data['username'])?$data['username']:$data['first_name']).'@dummy.com');
		$user->tryLoadAny();
		$user['password']='123456';
		$user->save();

		$this['user_id'] = $user->id;

		$this->save();
	}
} 