<?php

namespace xavoc\mlm;


class Model_Introducer extends Model_Distributor {
	public $table_alias =  'introducer';
	function init(){
		parent::init();
		$this->addExpression('distributor_name_with_username')
					->set($this->dsql()
						->expr('CONCAT([0]," :: ",[1])',
												[
													$this->getElement('name'),
													$this->getElement('user')
												]
							)
					)->sortable(true);
	}
} 