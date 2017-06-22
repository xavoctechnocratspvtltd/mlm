<?php

namespace xavoc\mlm;


class Model_Item extends \xepan\commerce\Model_Item {
	// public $table = "item";

	function init(){
		parent::init();

		// PV
		$specification = $this->add('xepan\commerce\Model_Item_Specification');
		$specification->addCondition('name','PV');
		
		$spec_assos_j1 = $this->join('customfield_association.item_id',null,null,'pv_j');
		$spec_assos_j1->addField('pv_customfield_generic_id','customfield_generic_id');
		$spec_assos_j1->addField('pv_status','status')->defaultValue('Active')->system(true);

		$spec_value_j1 = $spec_assos_j1->join('customfield_value.customfield_association_id',null,null,'pv_value_j');
		$spec_value_j1->addField('pv','name');//->display(array('form'=>'Readonly'));
		$spec_value_j1->addField('pv_value_status','status')->defaultValue('Active')->system(true);//->display(array('form'=>'Readonly'));
		
		$this->addCondition('pv_customfield_generic_id',$specification->fieldQuery('id'));
		
		// BV
		$specification = $this->add('xepan\commerce\Model_Item_Specification');
		$specification->addCondition('name','BV');
		
		$spec_assos_j1 = $this->join('customfield_association.item_id',null,null,'bv_j');
		$spec_assos_j1->addField('bv_customfield_generic_id','customfield_generic_id');
		$spec_assos_j1->addField('bv_status','status')->defaultValue('Active')->system(true);

		$spec_value_j1 = $spec_assos_j1->join('customfield_value.customfield_association_id',null,null,'bv_value_j');
		$spec_value_j1->addField('bv','name');//->display(array('form'=>'Readonly'));
		$spec_value_j1->addField('bv_value_status','status')->defaultValue('Active')->system(true);//->display(array('form'=>'Readonly'));
		
		$this->addCondition('bv_customfield_generic_id',$specification->fieldQuery('id'));
		
		// SV
		$specification = $this->add('xepan\commerce\Model_Item_Specification');
		$specification->addCondition('name','SV');
		
		$spec_assos_j1 = $this->join('customfield_association.item_id',null,null,'sv_j');
		$spec_assos_j1->addField('sv_customfield_generic_id','customfield_generic_id');
		$spec_assos_j1->addField('sv_status','status')->defaultValue('Active')->system(true);

		$spec_value_j1 = $spec_assos_j1->join('customfield_value.customfield_association_id',null,null,'sv_value_j');
		$spec_value_j1->addField('sv','name');//->display(array('form'=>'Readonly'));
		$spec_value_j1->addField('sv_value_status','status')->defaultValue('Active')->system(true);//->display(array('form'=>'Readonly'));
		
		$this->addCondition('sv_customfield_generic_id',$specification->fieldQuery('id'));

		// Capping
		$specification = $this->add('xepan\commerce\Model_Item_Specification');
		$specification->addCondition('name','Capping');
		
		$spec_assos_j1 = $this->join('customfield_association.item_id',null,null,'cp_j');
		$spec_assos_j1->addField('cp_customfield_generic_id','customfield_generic_id');
		$spec_assos_j1->addField('cp_status','status')->defaultValue('Active')->system(true);

		$spec_value_j1 = $spec_assos_j1->join('customfield_value.customfield_association_id',null,null,'cp_value_j');
		$spec_value_j1->addField('capping','name');//->display(array('form'=>'Readonly'));
		$spec_value_j1->addField('cp_value_status','status')->defaultValue('Active')->system(true);//->display(array('form'=>'Readonly'));
		
		$this->addCondition('cp_customfield_generic_id',$specification->fieldQuery('id'));

		// Introduction Income
		$specification = $this->add('xepan\commerce\Model_Item_Specification');
		$specification->addCondition('name','Introduction Income');
		
		$spec_assos_j1 = $this->join('customfield_association.item_id',null,null,'ii_j');
		$spec_assos_j1->addField('ii_customfield_generic_id','customfield_generic_id');
		$spec_assos_j1->addField('ii_status','status')->defaultValue('Active')->system(true);

		$spec_value_j1 = $spec_assos_j1->join('customfield_value.customfield_association_id',null,null,'ii_value_j');
		$spec_value_j1->addField('introducer_income','name');//->display(array('form'=>'Readonly'));
		$spec_value_j1->addField('ii_value_status','status')->defaultValue('Active')->system(true);//->display(array('form'=>'Readonly'));
		
		$this->addCondition('ii_customfield_generic_id',$specification->fieldQuery('id'));

		// DP distributor point
		$specification = $this->add('xepan\commerce\Model_Item_Specification');
		$specification->addCondition('name','DP');
		
		$spec_assos_j1 = $this->join('customfield_association.item_id',null,null,'dp_j');
		$spec_assos_j1->addField('dp_customfield_generic_id','customfield_generic_id');
		$spec_assos_j1->addField('dp_status','status')->defaultValue('Active')->system(true);

		$spec_value_j1 = $spec_assos_j1->join('customfield_value.customfield_association_id',null,null,'dp_value_j');
		$spec_value_j1->addField('dp','name');//->display(array('form'=>'Readonly'));
		$spec_value_j1->addField('dp_value_status','status')->defaultValue('Active')->system(true);//->display(array('form'=>'Readonly'));
		
		$this->addCondition('dp_customfield_generic_id',$specification->fieldQuery('id'));

		$this->getElement('status')->defaultValue('Published');
	}
}