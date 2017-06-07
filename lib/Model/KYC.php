<?php

namespace xavoc\mlm;


class Model_KYC extends \xepan\base\Model_Table {
	public $table = "mlm_kyc";

	function init(){
		parent::init();


		$this->addField('pan_no');
		$this->add('xepan\filestore\Field_Image','pan_image_id')->caption('Upload Your Pan Card');
		$this->addField('aadhar_no');
		$this->add('xepan\filestore\Field_Image','aadhar_image_id')->caption('Upload Your Aadhar Card');

		$this->is([
				'pan_no|to_trim|required',
				'pan_image_id|to_trim|required',
				'aadhar_no|to_trim|required',
				'aadhar_image_id|to_trim|required'
			]);
	}
}