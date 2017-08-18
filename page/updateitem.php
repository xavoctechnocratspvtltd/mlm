<?php


namespace xavoc\mlm;

class page_updateitem extends \xepan\base\Page {
	public $title= "Test Page";

	function init(){
		parent::init();

		$f = $this->add('Form');
		$f->addSubmit('update mlm item table from commerce table');
		if($f->isSubmitted()){
			$ci = $this->add('xepan\commerce\Model_Item');

			$query = "INSERT into mlm_item (item_id,pv,bv,sv,capping,introducer_income,dp) VALUES";
			foreach ($ci as $i) {
				$spec = $i->getSpecification();
				$query .= '('.$i->id.','.($spec['pv']?:0).','.($spec['bv']?:0).','.($spec['sv']?:0).','.($spec['capping']?:0).','.($spec['introducer_income']?:0).','.($spec['dp']?:0).'),';
			}

			$query = trim($query,',');
			$this->app->db->dsql()->expr($query)->execute();
			
			$f->js()->univ()->successMessage('updated')->execute();
		}

	}
}