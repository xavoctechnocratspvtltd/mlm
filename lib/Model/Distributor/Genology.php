<?php

namespace xavoc\mlm;


/**
* 
*/
class Model_Distributor_Genology extends \xavoc\mlm\Model_Distributor
{
	
	function init(){
		parent::init();


		$this->addExpression('generation_business')->set(function($m,$q){

			$x = $m->add('xavoc\mlm\Model_GenerationBusiness',['table_alias'=>'generation_business']);
			$x->addCondition('month_bv','>',0);
			return $x->addCondition('distributor_id',$q->getField('id'))
						->_dsql()->del('fields')->field($q->expr('group_concat([0] SEPARATOR ",")',[$x->getElement('name')]));
		});

	}

}