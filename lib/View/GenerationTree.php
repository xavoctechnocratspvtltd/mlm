<?php

namespace xavoc\mlm;

class View_GenerationTree extends \CompleteLister{

	public $options = [
						'generation-depth-of-tree'=> 5,
						'generation-show-info-on'=>"hover",
						'introducer_id'=>0
	];

	function init(){
		parent::init();

		$model = $this->add('xavoc\mlm\Model_Distributor');
		if($this->options['introducer_id'])
			$model->addCondition('introducer_id',$this->options['introducer_id']);
		else{
			$model->addCondition('introducer_id',0);
		}

		$this->setModel($model);
		

		// $this->add('xepan\cms\Controller_Tool_Optionhelper',['options'=>$this->options,'model'=>$model]);
	}

	function formatRow(){
		

		$child_gen = $this->add('xavoc\mlm\Model_Distributor',['name'=>'model_child_'.$this->model->id]);
		$child_gen->addCondition('introducer_id',$this->model->id);
		if($child_gen->count()->getOne() > 0){

			$this->options['introducer_id'] = $this->model->id;
			$child_gen_view = $this->add('xavoc\mlm\View_GenerationTree',['options'=>$this->options],'nested_generation',['view\generationtree','generation_list']);
			$child_gen_view->setModel($child_gen);
			$this->current_row_html['nested_generation']= $child_gen_view->getHTML();
			// $this->add('View',null,'nested_generation')->set($this->model['name']);
		}else{
			$this->current_row_html['nested_generation'] = "";
		}
		
		parent::formatRow();
	}

	function defaultTemplate(){
		return ['view/generationtree'];
	}
};