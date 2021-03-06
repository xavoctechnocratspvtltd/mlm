<?php

namespace xavoc\mlm;


class Model_Item extends \xepan\commerce\Model_Item {
	// public $table = "item";

	function init(){
		parent::init();

		$this->getElement('qty_unit_id')->defaultValue($this->add('xepan\commerce\Model_Unit')->tryLoadAny()->get('id'));
		$this->getElement('sale_price')->caption('MRP');
		$this->getElement('maintain_inventory')->defaultValue(1);

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
		$item_j->addField('introduction_income');
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

		$this->addHook('beforeSave', $this);
	}

	function beforeSave(){
		$this['introduction_income'] = $this['introducer_income'];
		
		$this->createTax();
	}

	function createTax($igst=true,$gst=true){
		// if(!$this->loaded()) throw new \Exception('item model must loaded');
		
		if(!$this['tax_percentage']) return;

		$return_array = []; 
		// IGST Tax
		if($igst){
			$gst_tax_name = "GST ".$this['tax_percentage']."% (IGST)";
			$taxation = $this->add('xepan\commerce\Model_Taxation');
			$taxation->addCondition('name',$gst_tax_name)
					->addCondition('percentage',$this['tax_percentage'])
					;
			$taxation->tryLoadAny();
			if(!$taxation->loaded()) $taxation->save();

			$sub_tax = $this->add('xepan\commerce\Model_Taxation');
			$sub_tax->addCondition('name','IGST');
			$sub_tax->addCondition('percentage',$this['tax_percentage']);
			$sub_tax->tryLoadAny();
			$sub_tax['show_in_qsp'] = 0;
			$sub_tax->save();

			$igst_id = $sub_tax->id."-".$sub_tax['name']."-".$sub_tax['percentage'];
			$taxation['sub_tax'] = $igst_id;
			$taxation->save();

			$return_array['igst'] = ['taxation_id'=>$taxation->id];
		}
		
		// GST Tax
		if($gst){
			$gst_tax_name = "GST ".$this['tax_percentage']."%";

			$taxation = $this->add('xepan\commerce\Model_Taxation');
			$taxation->addCondition('name',$gst_tax_name)
					->addCondition('percentage',$this['tax_percentage'])
					;
			$taxation->tryLoadAny();
			if(!$taxation->loaded()) $taxation->save();

			$sub_tax = $this->add('xepan\commerce\Model_Taxation');
			$sub_tax->addCondition('name','CGST');
			$sub_tax->addCondition('percentage',($this['tax_percentage']/2));
			$sub_tax->tryLoadAny();
			$sub_tax['show_in_qsp'] = 0;
			$sub_tax->save();

			$cgst_id = $sub_tax->id."-".$sub_tax['name']."-".$sub_tax['percentage'];

			$sub_tax = $this->add('xepan\commerce\Model_Taxation');
			$sub_tax->addCondition('name','SGST');
			$sub_tax->addCondition('percentage',($this['tax_percentage']/2));
			$sub_tax->tryLoadAny();
			$sub_tax['show_in_qsp'] = 0;
			$sub_tax->save();

			$sgst_id = $sub_tax->id."-".$sub_tax['name']."-".$sub_tax['percentage'];

			$taxation['sub_tax'] = $cgst_id.",".$sgst_id;
			$taxation->save();

			$return_array['gst'] = ['taxation_id'=>$taxation->id];
		}

		return $return_array;
	}


	function getTaxAmount($contact_id,$qty=1,$from_dp=true){

		$tax_array = [
						'tax_apply'=>'none',
						'base_amount'=>0,
						'taxation_id'=>0,
						'tax_amount'=>0,
						'tax_percentage'=>0,
						'cgst_amount'=>0,
						'cgst_percentage'=>0,
						'sgst_amount'=>0,
						'sgst_percentage'=>0,
						'igst_amount'=>0,
						'igst_percentage'=>0,
						'net_amount'=> 0
					];

		if(!$this['tax_percentage']) return $tax_array;

		$state_model = $this->add('xepan\base\Model_State');
		$state_model->addCondition('name','Gujarat');
		$state_model->tryLoadAny();
		if(!$state_model->loaded()) throw new \Exception("state model not found");

		$contact = $this->add('xepan\base\Model_Contact')->load($contact_id);

		$igst = false;
		$gst = false;
		if($state_model->id == $contact['state_id']){
			$gst_tax_name = "GST ".$this['tax_percentage']."%";
			$gst = true;
		}else{
			$gst_tax_name = "GST ".$this['tax_percentage']."% (IGST)";
			$igst = true;
		}

		$taxation = $this->add('xepan\commerce\Model_Taxation');
		$taxation->addCondition('name',$gst_tax_name)
				->addCondition('percentage',$this['tax_percentage'])
				;
		$taxation->tryLoadAny();
		if(!$taxation->loaded()){
			$tax_array = $this->createTax($igst,$gst);
			$temp_tax_name = "igst";
			if($gst){
				$temp_tax_name = 'gst';
			}

			$taxation_id = $tax_array[$temp_tax_name];

			$taxation = $this->add('xepan\commerce\Model_Taxation')->load($taxation_id);
		}
					

		$tax_percentage = $taxation['percentage'];

		if($from_dp)
			$base_amount = $this['dp'] * $qty;
		else
			$base_amount = $this['sale_price'] * $qty;

		$tax_amount =  ($base_amount * $tax_percentage)/100;

		// GST = CGST/SGST
		$tax_array['base_amount'] = $base_amount;
		$tax_array['tax_amount'] = $tax_amount;
		$tax_array['tax_percentage'] = $this['tax_percentage'];
		$tax_array['net_amount'] = $base_amount + $tax_amount;
		$tax_array['taxation_id'] = $taxation->id;
		
		if($state_model->id == $contact['state_id']){
			$tax_array['cgst_amount'] = ($tax_amount/2);
			$tax_array['cgst_percentage'] = ($tax_percentage/2);
			$tax_array['sgst_amount'] = ($tax_amount/2);
			$tax_array['sgst_percentage'] = ($tax_percentage/2);
		}else{
			// IGST Calculation
			$tax_array['igst_amount'] = $tax_amount;
			$tax_array['igst_percentage'] = $tax_percentage;
			$tax_array['tax_apply'] = 'igst';
		}

		return $tax_array;
	}

}