<?php

namespace xavoc\mlm;

class View_GalleryCategoryImage extends \View{
	public $options = ['show_description'=>true];

	function init(){
		parent::init();

		$cat_id = $this->app->stickyGET('catid');

		$m = $this->add('xavoc\mlm\Model_GalleryImages')
			->addCondition('category_id',$cat_id)
			->setOrder('id','desc');
		
		$this->complete_lister = $cl = $this->add('CompleteLister',null,null,['xavoc/tool/gallerylist']);
		$cl->setModel($m);

		$cat_model = $this->add('xavoc\mlm\Model_GalleryCategory');
		$cat_model->load($cat_id);

		$cl->add('View',null,'heading')
			->addClass('text-center')
			->setHtml('<a href="#">see all gallery</a>')->js('click')->redirect($this->app->url(null,['type'=>'gallery']));

		$cl->add('View',null,'heading')->addClass('text-center')
			->setElement('h2')
			->set('Photos of '.$cat_model['name']);

		// $this->app->stickyForget('catid');

		if($m->count()->getOne()){
			$cl->template->del('not_found');
		}else{
			$cl->template->set('not_found_message','No Record Found');
		}

		$cl->add('xepan\cms\Controller_Tool_Optionhelper',['options'=>$this->options,'model'=>$m]);

		$paginator = $cl->add('Paginator',['ipp'=>16]);
		$paginator->setRowsPerPage(16);
		// $this->on('click','.mlm-gallery-category',function($js,$data){			
		// 	if($data['imgcount'] > 0){
		// 		return $this->app->js()->redirect($this->app->url(null,['type'=>'gallerylist','catid'=>$data['catid']]));
		// 	}
		// 	return $this->app->js()->univ()->errorMessage('no one image found in this category');
		// });

		$cl->js(true)->_load($this->app->url()->absolute()->getBaseURL().'vendor/xepan/commerce/templates/js/tool/jquery-elevatezoom.js')
			   ->_load($this->app->url()->absolute()->getBaseURL().'vendor/xepan/commerce/templates/js/tool/jquery.fancybox.js')
				->_css("tool/jquery.fancybox-buttons")
				->_css("tool/jquery.fancybox");
		$cl->js(true)->_selector('.fancybox')->fancybox();
	}

	function addToolCondition_row_show_description($value,$l){
		if(!$value){
			$l->current_row_html['description']='';
			return;
		}
		$l->current_row_html['photos'] = ' ';

		if($this->options['show_description']){
			$l->current_row_html['description'] = $l->model['description'];
		}else{
			$l->current_row_html['description']=" ";
		}
	}
};