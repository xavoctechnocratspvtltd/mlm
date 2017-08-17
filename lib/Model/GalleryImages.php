<?php

namespace xavoc\mlm;


class Model_GalleryImages extends \xepan\base\Model_Table {
	public $table = "mlm_gallery_image";

	function init(){
		parent::init();

		$this->hasOne('xavoc\mlm\Model_GalleryCategory','category_id');

		$this->addField('name');
		$this->add('xepan\filestore\Field_File','image_id');
		$this->addField('description')->display(['form'=>'xepan\base\RichText'])->type('text');

		$this->add('dynamic_model/Controller_AutoCreator');

		$this->is(['image_id|required']);
	}
}