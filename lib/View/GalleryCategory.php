<?php

namespace xavoc\mlm;

class View_GalleryCategory extends \View{
	public $options = ['show_description'=>true];

	function init(){
		parent::init();

		$m = $this->add('xavoc\mlm\Model_GalleryCategory')
			->addCondition('status','active')
			;
		
		$this->complete_lister = $cl = $this->add('CompleteLister',null,null,['xavoc/tool/gallery']);
		$cl->setModel($m);
		$cl->add('View',null,'heading')->addClass('text-center')
			->setElement('h2')
			->set('Gallery');

		if($m->count()->getOne()){
			$cl->template->del('not_found');
		}else{
			$cl->template->set('not_found_message','No Record Found');
		}

		$cl->add('xepan\cms\Controller_Tool_Optionhelper',['options'=>$this->options,'model'=>$m]);
		
		$this->on('click','.mlm-gallery-category',function($js,$data){			
			if($data['imgcount'] > 0){
				return $this->app->js()->redirect($this->app->url(null,['type'=>'gallerylist','catid'=>$data['catid']]));
			}
			return $this->app->js()->univ()->errorMessage('no one image found in this category');
		});
	}

	function addToolCondition_row_show_description($value,$l){
		if(!$value){
			$l->current_row_html['description']='';
			return;
		}
		if($this->options['show_description']){
			$l->current_row_html['description'] = $l->model['description'];
		}else{
			$l->current_row_html['description']=" ";
		}
	}
};