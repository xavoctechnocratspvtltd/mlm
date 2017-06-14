<?php

namespace xavoc\mlm;


class Model_Distributor extends \xepan\commerce\Model_Customer {

public $status = ['Red','KitSelected','KitPaid','Green','Blocked'];
	public $actions = [
				'Red'=>['view','edit','delete'],
				'KitSelected'=>['view','edit','delete','verifyPayment','verifyDocument','Document'],
				'KitPaid'=>['view','edit','delete','verifyPayment','verifyDocument','markGreen'],
				'Green'=>['view','edit','delete','Document','verifyDocument'],
				'Blocked'=>['view','edit','delete','Unblocked']
				];
				
	public $acl_type= "ispmanager_distributor";


	function init(){
		parent::init();

		$this->getElement('status')->defaultValue('Red');

		$dist_j = $this->join('mlm_distributor.distributor_id');

		$dist_j->hasOne('xavoc\mlm\Sponsor','sponsor_id')->display(['form'=>'xepan\base\Basic'])->defaultValue(0);
		$dist_j->hasOne('xavoc\mlm\Introducer','introducer_id')->display(['form'=>'xepan\base\Basic'])->defaultValue(0);

		$dist_j->hasOne('xavoc\mlm\Left','left_id')->display(['form'=>'xepan\base\DropDownNormal']);
		$dist_j->hasOne('xavoc\mlm\Right','right_id')->display(['form'=>'xepan\base\DropDownNormal']);
		$dist_j->hasOne('xavoc\mlm\RePurchaseBonusSlab','current_rank_id')->defaultValue($this->add('xavoc\mlm\Model_RePurchaseBonusSlab')->tryLoadBy('slab_percentage',0)->get('id'));

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
		$dist_j->addField('month_self_bv')->type('int')->defaultValue(0);
		$dist_j->addField('total_self_bv')->type('int')->defaultValue(0);
		$dist_j->addField('month_bv')->type('int')->defaultValue(0);
		$dist_j->addField('total_month_bv')->type('int')->defaultValue(0);
		$dist_j->addField('quarter_bv_saved')->type('int')->defaultValue(0);
		$dist_j->addField('monthly_retail_profie')->type('int')->defaultValue(0);
		
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

		// distributor account detail
		$dist_j->addField('d_account_number');
		$dist_j->addField('d_bank_name');
		$dist_j->addField('d_bank_ifsc_code');

		// payment mode fields
		// for online payment
		$dist_j->addField('payment_mode')->enum(['online','cash','cheque','dd','deposite_in_franchies','deposite_in_company']);
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
		$dist_j->addField('is_payment_verified')->type('boolean')->defaultValue(false);
		$dist_j->addField('deposite_in_office_narration')->type('text');
		// $dist_j->addField('current_rank');
		$dist_j->addField('is_document_verified')->type('boolean');
		$dist_j->addField('sale_order_id');

		$this->hasMany('xavoc\mlm\GenerationBusiness','distributor_id');
		$this->hasMany('xavoc\mlm\Attachment','distributor_id');
		$this->hasMany('xavoc\mlm\TopupHistory','distributor_id');
		
		$this->addHook('beforeSave',array($this,'beforeSaveDistributor'),[],1);
		$this->addHook('afterSave',array($this,'afterSaveDistributor'));
		$this->addHook('beforeDelete',array($this,'beforeDeleteDistributor'));
		$this->addHook('afterInsert',$this);

		$this->add('Controller_Validator');
		if(!isset($this->app->skip_sponsor_introducer_mandatory)){
			$this->is(array(
							'sponsor_id|to_trim|required',
							'introducer_id|to_trim|required'
							// 're_password|to_trim',
						)
					);
		}

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

			$introducer = $this->introducer();

			if(!$this['sponsor_id']){
				$this['sponsor_id'] = $this->findSponsor($introducer, $this['side'])->get('id');
			}

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
			
			$this->welcomeDistributor();

			// $m_no=$this['mobile_number'];
		
    		// $message= "Thank you for joining Nebula! We have send your login Credentials on your registered email ID. Please Call us \n on 18004192299 for any assistance. Happy Networking!\nBest Regards,\nNebula Team - Reach Beyond";
		
			// $this->add('Controller_Sms')->sendMessage($m_no,$message);

			if($this->introducer()){
				$bv_table = $this->add('xavoc\mlm\Model_GenerationBusiness');
				$bv_table->addCondition('introduced_id',$this->id);
				$bv_table->addCondition('distributor_id',$this['introducer_id']);
				$bv_table->tryLoadAny();
				// $bv_table['introduced_path'] = $this['path'];
				$bv_table['introduced_path'] = $this['introducer_path'];
				$bv_table->save();
			}


			$this->forget('leg');
			
			if($introducer = $this->introducer()){
				$this['introducer_path'] = $introducer['introducer_path'] . '.'.$this['id'];
				$this->save();
			}

			// $this->api->db->dsql()->table('xshop_memberdetails')->where('id',$this['customer_id'])->set('users_id',$this['user_id'])->update();
		}
	}

	// send email and send sms
	function welcomeDistributor(){
		if(!$this->loaded()) throw new \Exception("Distributor Not Found, some thing wrong");
				
		// welcome mail and sms
		$welcome_model = $this->add('xepan\base\Model_ConfigJsonModel',
			[
				'fields'=>[
							'welcome_mail_subject'=>'Line',
							'welcome_mail_content'=>'xepan\base\RichText',
							'welcome_sms_content'=>'Text',
							'green_mail_subject'=>'Line',
							'green_mail_content'=>'xepan\base\RichText',
							'green_sms_content'=>'Text',
							'deactivate_mail_subject'=>'Line',
							'deactivate_mail_content'=>'xepan\base\RichText',
							'deactivate_sms_content'=>'Text',
							'payout_mail_subject'=>'Line',
							'payout_mail_content'=>'xepan\base\RichText',
							'payout_sms_content'=>'Text',
							'topup_mail_subject'=>'Line',
							'topup_mail_content'=>'xepan\base\RichText',
							'topup_sms_content'=>'Text',
						],
					'config_key'=>'DM_WELCOME_CONTENT',
					'application'=>'mlm'
			]);
		$welcome_model->tryLoadAny();
		

		// Send Email
			// subject
		if($this->app->getConfig('send_email',false)){

			if(!$welcome_model['welcome_mail_subject'] OR !$welcome_model['welcome_mail_content']) throw new \Exception("plase update welcome mail content");
			$temp = $this->add('GiTemplate');
			$temp->loadTemplateFromString($welcome_model['welcome_mail_subject']);
			$temp->set($this->data);
			$subject = $temp->render();
				// body
			$temp = $this->add('GiTemplate');
			$temp->loadTemplateFromString($welcome_model['welcome_mail_content']);
			$temp->set($this->data);
			$body = $temp->render();

			$email_setting = $this->add('xepan\communication\Model_Communication_EmailSetting')->setOrder('id','asc');
			$email_setting->addCondition('is_active',true);
			$email_setting->tryLoadAny();

			if(!$email_setting->loaded()) throw new \Exception("update your email setting ", 1);


			$communication = $this->add('xepan\communication\Model_Communication_Abstract_Email');
			$communication->addCondition('communication_type','Email');

			$communication->getElement('status')->defaultValue('Draft');
			$communication['direction']='Out';
			$communication->setfrom($email_setting['from_email'],$email_setting['from_name']);
			
			$communication->addTo($this['email']);
			$communication->setSubject($subject);
			$communication->setBody($body);
			$communication->send($email_setting);
		}

		// send SMS
		if($this->app->getConfig('send_sms',false)){
			$message = $welcome_model['welcome_sms_content'];
			$temp = $this->add('GiTemplate');
			$temp->loadTemplateFromString($message);
			$temp->set($this->data);
			$message = $temp->render();
			
			if(!$welcome_model['welcome_sms_content']) throw new \Exception("plase update welcome sms content");
			$this->add('xepan\communication\Controller_Sms')->sendMessage($this['mobile_number'],$message);
		}
	}

	// send email and send sms
	function sendMailGreenDistributor(){
		if(!$this->loaded()) throw new \Exception("Distributor Not Found, some thing wrong");
				
		// welcome mail and sms
		$green_config = $this->add('xepan\base\Model_ConfigJsonModel',
			[
				'fields'=>[
							'welcome_mail_subject'=>'Line',
							'welcome_mail_content'=>'xepan\base\RichText',
							'welcome_sms_content'=>'Text',
							'green_mail_subject'=>'Line',
							'green_mail_content'=>'xepan\base\RichText',
							'green_sms_content'=>'Text',
							'deactivate_mail_subject'=>'Line',
							'deactivate_mail_content'=>'xepan\base\RichText',
							'deactivate_sms_content'=>'Text',
							'payout_mail_subject'=>'Line',
							'payout_mail_content'=>'xepan\base\RichText',
							'payout_sms_content'=>'Text',
							'topup_mail_subject'=>'Line',
							'topup_mail_content'=>'xepan\base\RichText',
							'topup_sms_content'=>'Text',
						],
					'config_key'=>'DM_WELCOME_CONTENT',
					'application'=>'mlm'
			]);
		$green_config->tryLoadAny();
		

		// Send Email
			// subject
		if($this->app->getConfig('send_email',false)){

			if(!$green_config['green_mail_subject'] OR !$green_config['green_mail_content']) throw new \Exception("plase update Green Distributor mail content");
			$temp = $this->add('GiTemplate');
			$temp->loadTemplateFromString($green_config['green_mail_subject']);
			$temp->set($this->data);
			$subject = $temp->render();
				// body
			$temp = $this->add('GiTemplate');
			$temp->loadTemplateFromString($green_config['green_mail_content']);
			$temp->set($this->data);
			$body = $temp->render();

			$email_setting = $this->add('xepan\communication\Model_Communication_EmailSetting')->setOrder('id','asc');
			$email_setting->addCondition('is_active',true);
			$email_setting->tryLoadAny();

			if(!$email_setting->loaded()) throw new \Exception("update your email setting ", 1);


			$communication = $this->add('xepan\communication\Model_Communication_Abstract_Email');
			$communication->addCondition('communication_type','Email');

			$communication->getElement('status')->defaultValue('Draft');
			$communication['direction']='Out';
			$communication->setfrom($email_setting['from_email'],$email_setting['from_name']);
			
			$communication->addTo($this['email']);
			$communication->setSubject($subject);
			$communication->setBody($body);
			$communication->send($email_setting);
		}

		// send SMS
		if($this->app->getConfig('send_sms',false)){
			$message = $green_config['green_sms_content'];
			$temp = $this->add('GiTemplate');
			$temp->loadTemplateFromString($message);
			$temp->set($this->data);
			$message = $temp->render();
			
			if(!$green_config['green_sms_content']) throw new \Exception("plase update Green Distributor SMS content");
			$this->add('xepan\communication\Controller_Sms')->sendMessage($this['mobile_number'],$message);
		}
	}

	// send email and send sms
	function sendMailDeactivateDistributor(){
		if(!$this->loaded()) throw new \Exception("Distributor Not Found, some thing wrong");
				
		// welcome mail and sms
		$deactivate_config = $this->add('xepan\base\Model_ConfigJsonModel',
			[
				'fields'=>[
							'welcome_mail_subject'=>'Line',
							'welcome_mail_content'=>'xepan\base\RichText',
							'welcome_sms_content'=>'Text',
							'green_mail_subject'=>'Line',
							'green_mail_content'=>'xepan\base\RichText',
							'green_sms_content'=>'Text',
							'deactivate_mail_subject'=>'Line',
							'deactivate_mail_content'=>'xepan\base\RichText',
							'deactivate_sms_content'=>'Text',
							'payout_mail_subject'=>'Line',
							'payout_mail_content'=>'xepan\base\RichText',
							'payout_sms_content'=>'Text',
							'topup_mail_subject'=>'Line',
							'topup_mail_content'=>'xepan\base\RichText',
							'topup_sms_content'=>'Text',
						],
					'config_key'=>'DM_WELCOME_CONTENT',
					'application'=>'mlm'
			]);
		$deactivate_config->tryLoadAny();
		

		// Send Email
			// subject
		if($this->app->getConfig('send_email',false)){

			if(!$deactivate_config['deactivate_mail_subject'] OR !$deactivate_config['deactivate_mail_content']) throw new \Exception("plase update Deactivate Distributor mail content");
			$temp = $this->add('GiTemplate');
			$temp->loadTemplateFromString($deactivate_config['deactivate_mail_subject']);
			$temp->set($this->data);
			$subject = $temp->render();
				// body
			$temp = $this->add('GiTemplate');
			$temp->loadTemplateFromString($deactivate_config['deactivate_mail_content']);
			$temp->set($this->data);
			$body = $temp->render();

			$email_setting = $this->add('xepan\communication\Model_Communication_EmailSetting')->setOrder('id','asc');
			$email_setting->addCondition('is_active',true);
			$email_setting->tryLoadAny();

			if(!$email_setting->loaded()) throw new \Exception("update your email setting ", 1);


			$communication = $this->add('xepan\communication\Model_Communication_Abstract_Email');
			$communication->addCondition('communication_type','Email');

			$communication->getElement('status')->defaultValue('Draft');
			$communication['direction']='Out';
			$communication->setfrom($email_setting['from_email'],$email_setting['from_name']);
			
			$communication->addTo($this['email']);
			$communication->setSubject($subject);
			$communication->setBody($body);
			$communication->send($email_setting);
		}

		// send SMS
		if($this->app->getConfig('send_sms',false)){
			$message = $deactivate_config['deactivate_sms_content'];
			$temp = $this->add('GiTemplate');
			$temp->loadTemplateFromString($message);
			$temp->set($this->data);
			$message = $temp->render();
			
			if(!$deactivate_config['deactivate_sms_content']) throw new \Exception("plase update Deactivate Distributor SMS content");
			$this->add('xepan\communication\Controller_Sms')->sendMessage($this['mobile_number'],$message);
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

		$this->ref('xavoc\mlm\TopupHistory')->deleteAll();
	}

	function afterInsert($obj){
		
	}

	function purchaseKit($kit){

		$kit_id = $kit;
		if($kit instanceof \xavoc\mlm\Model_Kit)
			$kit_id = $kit->id;

		$this['kit_item_id']= $kit_id;
		$this['status'] = "KitSelected";
		
		$this->app->employee
		->addActivity("Distributor ".$this['name']." purchase a kit( ".$this['kit_item']." ) and waiting for payment verification")
		->notifyWhoCan(['PaymentVerified'],'KitPaid',$this);
		
		$this->save();

		$this->updateTopupHistory();
	}

	function updateTopupHistory(){
			
		$kit = $this->add('xavoc\mlm\Model_Kit')->load($this['kit_item_id']);

		$top_his = $this->add('xavoc\mlm\Model_TopupHistory');

		$top_his['distributor_id'] = $this['id'];
		$top_his['kit_item_id'] = $this['kit_item_id'];
		$top_his['sale_order_id'] = $this['sale_order_id'];
		
		$top_his['pv'] = $kit['pv'];
		$top_his['bv'] = $kit['bv'];
		$top_his['sv'] = $kit['sv'];
		$top_his['capping'] = $kit['capping'];
		$top_his['introduction_income'] = $kit['introduction_income'];
		$top_his['sale_price'] = $kit['sale_price'];

		// $top_his['cheque_deposite_receipt_image_id'] = $this->attachment['cheque_deposite_receipt_image_id'];
		// $top_his['dd_deposite_receipt_image_id'] = $this->attachment['dd_deposite_receipt_image_id'];
		// $top_his['office_receipt_image_id'] = $this->attachment['office_receipt_image_id'];
		$top_his->save();
	}
	function kitPaid(){
		$this['status'] = "KitPaid";

		$this->app->employee
		->addActivity("Distributor ".$this['name']." purchase a kit( ".$this['kit_item']." ) and waiting for payment verification")
		->notifyWhoCan(['PaymentVerified'],'KitPaid',$this);
		
		$this->save();	
	}

	function markGreen($on_date=null){
		if(!$on_date) $on_date =  $this->app->now;
		
		if($this['greened_on'])
			throw $this->exception('Distributor has already been green on '. $this['greened_on']);
		
		$this['greened_on'] = $on_date;
		$this['status'] = "Green";

		$kit = $this->kit();
		if(!$kit) throw new \Exception("Cannot mark green without kit", 1);
		
		$this['capping'] = $kit['capping'];
		$this['pv'] = $kit['pv'];
		$this['bv'] = $kit['bv'];
		$this['sv'] = $kit['sv'];

		$this['month_self_bv'] = $this['month_self_bv']+$kit['bv'];
		$this['total_self_bv'] = $this['total_self_bv']+$kit['bv'];

		if($this->app->getConfig('retail_profit_on_kit_purchase',false)){
			$this['monthly_retail_profie'] = $this['monthly_retail_profie'] + ($kit['sale_price'] - $kit['dp']);
		}

		$this->save();
		
		$this->updateAnsestorsSV($this['sv']);
		$this->updateAnsestorsBV($this['bv']);
		if($introducer  = $this->introducer()) $introducer->addSessionIntro($kit['introducer_income']);
		
		$this->updateTopupHistoryAttachment();
		$this->sendMailGreenDistributor();
	}

	function updateTopupHistoryAttachment(){

		$attch = $this->add('xavoc\mlm\Model_Attachment');
		$attch->addCondition('distributor_id',$this->id);
		$attch->tryLoadAny();

		$t = $this->add('xavoc\mlm\Model_TopupHistory');
		$t->addCondition('distributor_id',$this->id);
		$t->setOrder('id','desc');
		$t->tryLoadAny();

		$t['cheque_deposite_receipt_image_id'] = $attch['cheque_deposite_receipt_image_id']?:0;
		$t['dd_deposite_receipt_image_id'] = $attch['dd_deposite_receipt_image_id']?:0;
		$t['office_receipt_image_id'] = $attch['office_receipt_image_id']?:0;
		$t->save();
	}

	function repurchase($bv){
		$this['month_self_bv'] = $this['month_self_bv'] + $bv;
		$this['total_self_bv'] = $this['total_self_bv'] + $bv;
		
		// $this['month_bv'] = $this['month_bv'] + $bv;
		// $this['total_month_bv'] = $this['total_month_bv'] + $bv;
		// $this['quarter_bv_saved'] = $this['quarter_bv_saved'] + $bv;

		$this->save();
		$this->updateAnsestorsBV($bv);
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
		// Updates self record also
		$path = $this['introducer_path'];

		$q="
				UPDATE mlm_distributor d
				Inner Join 
				(SELECT 
					id,
					introducer_path,
					LEFT('$path',LENGTH(introducer_path)) desired
				 FROM mlm_distributor 
				 HAVING
				 desired=introducer_path
				 ) rights on rights.id = d.id
				SET
					month_bv = month_bv + $bv_points,
					total_month_bv = total_month_bv + $bv_points,
					quarter_bv_saved = quarter_bv_saved + $bv_points
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
		
		$user->addCondition('username',(isset($data['username'])?$data['username']:$data['first_name']));
		$user['password']= $data['password']?:'123456';
		$user->save();

		$this['user_id'] = $user->id;

		$this->save();
	}

	function isRoot(){
		return ($this['path'] == 0)?true:false;
	}
} 