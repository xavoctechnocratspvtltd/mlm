<?php

namespace xavoc\mlm;


class Model_Item extends \xepan\commerce\Model_Item {
	// public $table = "item";

	function init(){
		parent::init();

		$this->getElement('qty_unit_id')->defaultValue($this->add('xepan\commerce\Model_Unit')->tryLoadAny()->get('id'));
		$this->getElement('sale_price')->caption('MRP');
		

		$item_j = $this->join('mlm_item.item_id');

		$item_j->addField('item_id');
		$item_j->addField('pv');
		$item_j->addField('bv');
		$item_j->addField('sv');
		$item_j->addField('capping');
		$item_j->addField('introducer_income');
		$item_j->addField('dp');
		$item_j->addField('weight_in_gm');
		$item_j->addField('tax_percentage');

		// // PV
		// $specification = $this->add('xepan\commerce\Model_Item_Specification');
		// $specification->addCondition('name','PV');
		
		// $spec_assos_j1 = $this->join('customfield_association.item_id',null,null,'pv_j');
		// $spec_assos_j1->addField('pv_customfield_generic_id','customfield_generic_id');
		// $spec_assos_j1->addField('pv_status','status')->defaultValue('Active')->system(true);

		// $spec_value_j1 = $spec_assos_j1->join('customfield_value.customfield_association_id',null,null,'pv_value_j');
		// $spec_value_j1->addField('pv','name');//->display(array('form'=>'Readonly'));
		// $spec_value_j1->addField('pv_value_status','status')->defaultValue('Active')->system(true);//->display(array('form'=>'Readonly'));
		
		// $this->addCondition('pv_customfield_generic_id',$specification->fieldQuery('id'));
		
		// // BV
		// $specification = $this->add('xepan\commerce\Model_Item_Specification');
		// $specification->addCondition('name','BV');
		
		// $spec_assos_j1 = $this->join('customfield_association.item_id',null,null,'bv_j');
		// $spec_assos_j1->addField('bv_customfield_generic_id','customfield_generic_id');
		// $spec_assos_j1->addField('bv_status','status')->defaultValue('Active')->system(true);

		// $spec_value_j1 = $spec_assos_j1->join('customfield_value.customfield_association_id',null,null,'bv_value_j');
		// $spec_value_j1->addField('bv','name')->defaultValue(0);//->display(array('form'=>'Readonly'));
		// $spec_value_j1->addField('bv_value_status','status')->defaultValue('Active')->system(true);//->display(array('form'=>'Readonly'));
		
		// $this->addCondition('bv_customfield_generic_id',$specification->fieldQuery('id'));
		
		// // SV
		// $specification = $this->add('xepan\commerce\Model_Item_Specification');
		// $specification->addCondition('name','SV');
		
		// $spec_assos_j1 = $this->join('customfield_association.item_id',null,null,'sv_j');
		// $spec_assos_j1->addField('sv_customfield_generic_id','customfield_generic_id');
		// $spec_assos_j1->addField('sv_status','status')->defaultValue('Active')->system(true);

		// $spec_value_j1 = $spec_assos_j1->join('customfield_value.customfield_association_id',null,null,'sv_value_j');
		// $spec_value_j1->addField('sv','name')->defaultValue(0);//->display(array('form'=>'Readonly'));
		// $spec_value_j1->addField('sv_value_status','status')->defaultValue('Active')->system(true);//->display(array('form'=>'Readonly'));
		
		// $this->addCondition('sv_customfield_generic_id',$specification->fieldQuery('id'));

		// // Capping
		// $specification = $this->add('xepan\commerce\Model_Item_Specification');
		// $specification->addCondition('name','Capping');
		
		// $spec_assos_j1 = $this->join('customfield_association.item_id',null,null,'cp_j');
		// $spec_assos_j1->addField('cp_customfield_generic_id','customfield_generic_id');
		// $spec_assos_j1->addField('cp_status','status')->defaultValue('Active')->system(true);

		// $spec_value_j1 = $spec_assos_j1->join('customfield_value.customfield_association_id',null,null,'cp_value_j');
		// $spec_value_j1->addField('capping','name')->defaultValue(0);//->display(array('form'=>'Readonly'));
		// $spec_value_j1->addField('cp_value_status','status')->defaultValue('Active')->system(true);//->display(array('form'=>'Readonly'));
		
		// $this->addCondition('cp_customfield_generic_id',$specification->fieldQuery('id'));

		// // Introduction Income
		// $specification = $this->add('xepan\commerce\Model_Item_Specification');
		// $specification->addCondition('name','Introduction Income');
		
		// $spec_assos_j1 = $this->join('customfield_association.item_id',null,null,'ii_j');
		// $spec_assos_j1->addField('ii_customfield_generic_id','customfield_generic_id');
		// $spec_assos_j1->addField('ii_status','status')->defaultValue('Active')->system(true);

		// $spec_value_j1 = $spec_assos_j1->join('customfield_value.customfield_association_id',null,null,'ii_value_j');
		// $spec_value_j1->addField('introducer_income','name');//->display(array('form'=>'Readonly'));
		// $spec_value_j1->addField('ii_value_status','status')->defaultValue('Active')->system(true);//->display(array('form'=>'Readonly'));
		
		// $this->addCondition('ii_customfield_generic_id',$specification->fieldQuery('id'));

		// DP distributor point
		// $specification = $this->add('xepan\commerce\Model_Item_Specification');
		// $specification->addCondition('name','DP');
		
		// $spec_assos_j1 = $this->join('customfield_association.item_id',null,null,'dp_j');
		// $spec_assos_j1->addField('dp_customfield_generic_id','customfield_generic_id');
		// $spec_assos_j1->addField('dp_status','status')->defaultValue('Active')->system(true);

		// $spec_value_j1 = $spec_assos_j1->join('customfield_value.customfield_association_id',null,null,'dp_value_j');
		// $spec_value_j1->addField('dp','name')->defaultValue(0);//->display(array('form'=>'Readonly'));
		// $spec_value_j1->addField('dp_value_status','status')->defaultValue('Active')->system(true);//->display(array('form'=>'Readonly'));
		
		// $this->addCondition('dp_customfield_generic_id',$specification->fieldQuery('id'));

		// // weight in Gm distributor point
		// $weight_spec = $this->add('xepan\commerce\Model_Item_Specification');
		// $weight_spec->addCondition('name','weight_in_gm');
		
		// $j1 = $this->join('customfield_association.item_id',null,null,'weight_in_gm_j');
		// $j1->addField('weight_in_gm_customfield_generic_id','customfield_generic_id');
		// $j1->addField('weight_in_gm_status','status')->defaultValue('Active')->system(true);

		// $j2 = $j1->join('customfield_value.customfield_association_id',null,null,'weight_value_j');
		// $j2->addField('weight_in_gm','name')->defaultValue(0);//->display(array('form'=>'Readonly'));
		// $j2->addField('weight_in_gm_value_status','status')->defaultValue('Active')->system(true);//->display(array('form'=>'Readonly'));
		
		// $this->addCondition('weight_in_gm_customfield_generic_id',$specification->fieldQuery('id'));

		$this->getElement('status')->defaultValue('Published');
	}
}