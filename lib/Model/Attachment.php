<?php

namespace xavoc\mlm;


class Model_Attachment extends \xepan\base\Model_Table {
	public $table = "mlm_attachment";

	function init(){
		parent::init();

		$this->hasOne('xavoc\mlm\Model_Distributor','distributor_id');

		$this->add('xepan\filestore\Field_Image','pan_card_id')->caption('Upload Your Pan Card');
		$this->add('xepan\filestore\Field_Image','aadhar_card_id')->caption('Upload Your Aadhar Card');

		$this->add('xepan\filestore\Field_Image','cheque_deposite_receipt_image_id')->caption('Upload Your Aadhar Card');
		$this->add('xepan\filestore\Field_Image','dd_deposite_receipt_image_id')->caption('Upload Your Aadhar Card');
		
	}
}