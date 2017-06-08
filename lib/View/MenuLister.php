<?php
namespace xavoc\mlm;
class View_MenuLister extends \CompleteLister{
		public $options = [
			'menu_url' =>'index',
			"custom_template"=>'menubar',
			'show_item_count'=>false
		];

	function init(){
		parent::init();
		
		$model = $this->add('xepan\commerce\Model_Category');
		$model->addCondition($model->dsql()->orExpr()->where('parent_category_id',0)->where('parent_category_id',null))
				->addCondition('status','Active')
				->addCondition('is_website_display',true)
				;
		$model->setOrder('display_sequence','asc');
		$this->setModel($model);		

		// $this->add('xepan\cms\Controller_Tool_Optionhelper',['options'=>$this->options,'model'=>$model]);
	}
	
	function formatRow(){
		if($this->model['custom_link']){
		// 	// if custom link contains http or https then redirect to that website
			$has_https = strpos($this->model['custom_link'], "https");
			$has_http = strpos($this->model['custom_link'], "http");
			if($has_http === false or $has_https === false )
				$url = $this->app->url($this->model['custom_link'],['xsnb_category_id'=>$this->model->id]);
			else
				$url = $this->model['custom_link'];
			$this->current_row_html['url'] = $url;
		}else{
			$url = $this->app->url(($this->options['menu_url']?:"index"),['xsnb_category_id'=>$this->model->id]);
			
			$this->current_row_html['sub_url'] = $url;
		}

		$sub_cat = $this->add('xepan\commerce\Model_Category',['name'=>'model_child_'.$this->model->id]);
		$sub_cat->addCondition('parent_category_id',$this->model->id);
		$sub_cat->addCondition('status',"Active");
		$sub_cat->setOrder('display_sequence','asc');
		if($sub_cat->count()->getOne() > 0){
			$sub_c = $this->add('xavoc\mlm\View_MenuLister',['options'=>$this->options],'child_cat_lister',['view/tool/menubar','child_cat_lister']);
			// $sub_c = $this->add('xavoc\mlm\View_MenuLister',['options'=>$this->options],'child_cat_lister',['view\tool\/'.$this->options['custom_template'],'child_cat_lister']);
			$sub_c->setModel($sub_cat);
			$this->current_row_html['child_category']= $sub_c->getHTML();
		}else{
			$this->current_row_html['child_category'] = "";
		}
		parent::formatRow();
	}

	// function defaultTemplate(){		
	// 	return ['view/tool/'.$this->options['custom_template']];
	// }

	function defaultTemplate(){
		return ['view/tool/menubar'];
	}
}