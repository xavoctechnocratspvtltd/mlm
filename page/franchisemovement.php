<?php

namespace xavoc\mlm;

class page_franchisemovement extends \xepan\base\Page {
	public $title= "Franchises Movement";

	function init(){
		parent::init();


		$item_m = $this->add('xavoc\mlm\Model_Item');
		$item_m->addExpression('kit_with_price')->set(function($m,$q){
			return $q->expr('CONCAT([0]," :: ",[1]," ::",[2])',
									[
										$m->getElement('name'),
										$m->getElement('sku'),
										$m->getElement('sale_price')
									]
				);
		});
		$item_m->title_field = "kit_with_price";

		// session model
		$p_item = $this->add('Model',['table'=>'Items']);
		$p_item->setSource('Session');
		$p_item->hasOne($item_m,'item_id')->display(['form'=>'DropDown']);
		$p_item->addField('quantity')->type('number');

		$form = $this->add('Form');
		$col = $form->add('Columns')->addClass('row');
		$col1 = $col->addColumn(4)->addClass('col-md-4 col-sm-12 col-lg-4 col-xs-12');
		$col2 = $col->addColumn(4)->addClass('col-md-4 col-sm-12 col-lg-4 col-xs-12');
		$col3 = $col->addColumn(4)->addClass('col-md-4 col-sm-12 col-lg-4 col-xs-12');

		$form->add('View')->setElement('hr');

		$item_field = $col1->addField('DropDown','item_id')->validate('required');
		$item_field->setModel($item_m);
		$item_field->setEmptyText('Please select');

		$col2->addField('Number','quantity')->validate('required');
		$add_btn = $col3->addSubmit('add')->addClass('btn btn-primary')->setStyle('margin-top','10px;');

		$crud = $this->add('CRUD',['allow_add'=>false,'allow_edit'=>false]);

		if($form->isSubmitted()){
			$p_item['item_id'] = $form['item_id'];
			$p_item['quantity'] = $form['quantity'];
			$p_item->save();
			$crud->js(null,$form->js()->reload())->reload()->execute();
		}

		$crud->setModel($p_item,['quantity'],['item','quantity']);
		$crud->grid->addTotals(['quantity']);

		// $franchise_model = $this->add('xavoc\mlm\Model_Franchises')->addCondition('status','Active');
		$f_w_model = $this->add('xepan\commerce\Model_Store_Warehouse');
		$t_w_model = $this->add('xepan\commerce\Model_Store_Warehouse');

		$form_m = $this->add('Form');

		$col = $form_m->add('Columns')->addClass('row');
		$col1 = $col->addColumn(4)->addClass('col-md-6 col-sm-12 col-lg-6 col-xs-12');
		$col2 = $col->addColumn(4)->addClass('col-md-6 col-sm-12 col-lg-6 col-xs-12');	

		$from_warehouse_field = $col1->addField('DropDown','from_warehouse')->validate('required');
		$from_warehouse_field->setModel($f_w_model);
		$from_warehouse_field->setEmptyText('Please Select');

		$to_warehouse_field = $col2->addField('DropDown','to_warehouse')->validate('required');
		$to_warehouse_field->setModel($t_w_model);
		$to_warehouse_field->setEmptyText('Please Select');

		$form_m->addField('text','narration');
		$form_m->addSubmit('Transfer');
		if($form_m->isSubmitted()){
			if(!$p_item->count()) $form_m->js()->univ()->errorMessage('first add movement item')->execute();
			
			$from_warehouse = $this->add('xepan\commerce\Model_Store_Warehouse')->load($form_m['from_warehouse']);
			$transaction = $from_warehouse->newTransaction(null,null,$form_m['from_warehouse'],'Movement',null,$form_m['to_warehouse'],$form_m['narration'],null,'Received');

			foreach ($p_item as $mi) {
				$transaction->addItem(null,$mi['item_id'],$mi['quantity'],null,'{}','Received',$form_m['narration']);
			}			

			$p_item->deleteAll();
			$form_m->js(null,[$crud->js()->reload(),$form->js()->univ()->successMessage('stock transfered')])->reload()->execute();
		}

	}
}