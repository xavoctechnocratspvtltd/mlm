<?php


namespace xavoc\mlm;

class page_productpurchase extends \xepan\base\Page {
	public $title= "Product Purchase Entries";

	function page_index(){

		$m = $this->add('xavoc\mlm\Model_PurchaseInvoice');

		$crud = $this->add('xepan\hr\CRUD',['allow_add'=>false]);
		$crud->setModel($m);

		$add_btn = $crud->grid->add('Button',null,'grid_buttons')
					->addClass('btn btn-primary')
					->set('Add Purchase')
					->js('click')
					->univ()
					->dialogURL('Add Purchase',$this->app->url('./add'))
					;

	}

	function page_add(){
		$form = $this->add('Form');
		$form->addField('DropDown','supplier')->setModel('xepan\commerce\Model_Supplier');

		$c = $form->add('Columns')->addClass('row');
		$pc = $c->addColumn(6)->addClass('col-md-5');
		$qc = $c->addColumn(3)->addClass('col-md-2');
		$rc = $c->addColumn(3)->addClass('col-md-2');
		$tc = $c->addColumn(3)->addClass('col-md-2');
		$ac = $c->addColumn(3)->addClass('col-md-1');

		$item_m = $this->recall('item_model',false);
		if(!$item_m){			
			$item_m = $this->add('xepan\commerce\Model_Item');
			$this->memorize('item_model',$item_m);
		}

		$pc->addField('DropDown','product_id')->setEmptyText('Product ???')->setModel($item_m);
		$qc->addField('Number','qty');
		$rc->addField('Number','rate');
		$tc->addField('Number','tax');
		$add_btn = $ac->addSubmit('Add');

		$p_item = $this->add('Model',['table'=>'Products']);
		$p_item->setSource('Session');
		$p_item->hasOne($item_m,'product_id')->display(['form'=>'DropDown']);
		$p_item->addField('qty')->type('number');
		$p_item->addField('rate')->type('number');
		$p_item->addField('tax')->type('number');
		$p_item->addField('amount')->type('money');

		$p_item->addHook('beforeSave',function($m){
			$without_tax = ($m['qty'] * $m['rate']);
			$tax = $without_tax * $m['tax'] / 100;
			$m['amount']=$without_tax + $tax;
		});


		$crud = $this->add('CRUD');
		$crud->setModel($p_item,['product','qty','rate','tax'],['product','qty','rate','tax','amount']);

		if($form->isSubmitted()){
			if($form->isClicked($add_btn)){
				$p_item['product_id'] = $form['product_id'];
				$p_item['qty'] = $form['qty'];
				$p_item['rate'] = $form['rate'];
				$p_item['tax'] = $form['tax'];
				$p_item->save();
				$crud->js()->reload()->execute();
			}else{
				try{
					$this->api->db->beginTransaction();
					$master_detail=[
					];

					$detail_data=[];
					foreach ($p_item as $i) {
						$detail_data[] = [];
					}

					$ret = $this->add('xepan\commerce\Model_QSP_Master')->createQSP($master_detail,$detail_data,'PurchaseInvoice');
					$master = $this->add('xavoc\mlm\Model_PurchaseInvoice')->load($ret['master_detail']['id']);
					
					$company_ware_house=$this->add('xepan\commerce\Model_Store_Warehouse')->loadBy('name','company');

					$warehouse = $this->add('xepan\commerce\Model_Store_Warehouse')->load($form['item_warehouse_'.$oi->id]);
			        $transaction = $warehouse->newTransaction($master->id,$jobcard_id=null,$from_warehouse_id=$master['contact_id'],"Purchase",$department_id=null,$to_warehouse_id=$company_ware_house->id);
			        foreach ($$master->items() as $oi) {
	        			$tr_row = $transaction->addItem($oi->id,$item_id=$oi['item_id'],$form['item_received_qty_'.$oi->id],$jobcard_detail_id=null,$custom_field_combination=$oi->convertCustomFieldToKey(json_decode($oi['extra_info'],true)),$status="ToReceived",$oi['item_qty_unit_id'],$oi['qty_unit_id']);
	        			$tr_row->receive();
			        }
					
					$transaction->receive();

					$this->api->db->commit();
				}catch(\Exception $e){
					$this->api->db->rollback();
					throw $e;
					
				}
				$this->js()->univ()->errorMessage('Done')->execute();
			}
				$this->js()->univ()->errorMessage('final')->execute();
		}

	}

}