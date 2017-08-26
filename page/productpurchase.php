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
		$supplier_field = $form->addField('DropDown','supplier');
		$supplier_field->setModel('xepan\commerce\Model_Supplier');
		$supplier_field->setEmptyText('Please Select Supplier');

		$c = $form->add('Columns')->addClass('row');
		$pc = $c->addColumn(6)->addClass('col-md-4');
		$qc = $c->addColumn(2)->addClass('col-md-1');
		$rc = $c->addColumn(2)->addClass('col-md-1');
		$tt = $c->addColumn(2)->addClass('col-md-2');
		$tc = $c->addColumn(2)->addClass('col-md-1');
		$ac = $c->addColumn(2)->addClass('col-md-1');

		$item_m = $this->recall('item_model',false);
		if(!$item_m){
			$item_m = $this->add('xavoc\mlm\Model_Item');
			$this->memorize('item_model',$item_m);
		}
		$item_m->title_field = "name_with_detail";
		$item_m->addExpression('name_with_detail')->set(function($m,$q){
			return $q->expr('CONCAT([0]," :: ",[1]," ::",[2])',
									[
										$m->getElement('name'),
										$m->getElement('sku'),
										$m->getElement('sale_price')
									]
				);
		});

		$pc->addField('DropDown','product_id','Product')->setEmptyText('Product ???')->setModel($item_m);
		$qc->addField('Number','qty');
		$rc->addField('Number','rate');
		$tt->addField('DropDown','tax_type','Tax')
			->setValueList(['GST'=>'GST','IGST'=>'IGST'])
			->setEmptyText('none');

		$tc->addField('Number','tax_percentage','Tax %');

		$add_btn = $ac->addSubmit('Add Product')->addClass('btn btn-primary')->setStyle('margin-top','10px');

		$p_item = $this->add('Model',['table'=>'Products']);
		$p_item->setSource('Session');
		$p_item->hasOne($item_m,'product_id')->display(['form'=>'DropDown']);
		$p_item->addField('qty')->type('number');
		$p_item->addField('rate')->type('number');
		$p_item->addField('tax_type');
		$p_item->addField('tax_id')->type('number');
		$p_item->addField('qty_unit_id')->type('number');
		$p_item->addField('tax_percentage')->type('number');
		$p_item->addField('tax_amount')->type('number');
		$p_item->addField('amount')->type('money');

		$p_item->addHook('beforeSave',function($m){
			$without_tax = ($m['qty'] * $m['rate']);
			$tax = $without_tax * $m['tax_percentage'] / 100;
			$m['tax_amount'] = $tax;
			$m['amount']=$without_tax + $tax;
		});


		$crud = $this->add('CRUD',['allow_add'=>false]);
		$crud->setModel($p_item,['product','qty','rate','tax_type','tax_percentage'],['product','qty','rate','tax_type','tax_percentage','amount']);

		if($form->isSubmitted()){
			
			if($form->isClicked($add_btn)){
				// check tax exist or not
				$gst_tax_name = "GST ".$form['tax_percentage']."%";
				if($form['tax_type'] == "IGST"){
					$gst_tax_name = "GST ".$form['tax_percentage']."% (IGST)";
				}

				$taxation = $this->add('xepan\commerce\Model_Taxation');
				$taxation->addCondition('name',$gst_tax_name)
						->addCondition('percentage',$form['tax_percentage'])
						;
				$taxation->tryLoadAny();
				if(!$taxation->loaded()) $taxation->save();

				if($form['tax_type'] == "IGST"){
					$sub_tax = $this->add('xepan\commerce\Model_Taxation');
					$sub_tax->addCondition('name','IGST');
					$sub_tax->addCondition('percentage',$form['tax_percentage']);
					$sub_tax->tryLoadAny();
					$sub_tax['show_in_qsp'] = 0;
					$sub_tax->save();

					$igst_id = $sub_tax->id."-".$sub_tax['name']."-".$sub_tax['percentage'];
					$taxation['sub_tax'] = $igst_id;
					$taxation->save();					

				}elseif($form['tax_type'] == "GST"){
					$sub_tax = $this->add('xepan\commerce\Model_Taxation');
					$sub_tax->addCondition('name','CGST');
					$sub_tax->addCondition('percentage',($form['tax_percentage']/2));
					$sub_tax->tryLoadAny();
					$sub_tax['show_in_qsp'] = 0;
					$sub_tax->save();

					$cgst_id = $sub_tax->id."-".$sub_tax['name']."-".$sub_tax['percentage'];

					$sub_tax = $this->add('xepan\commerce\Model_Taxation');
					$sub_tax->addCondition('name','SGST');
					$sub_tax->addCondition('percentage',($form['tax_percentage']/2));
					$sub_tax->tryLoadAny();
					$sub_tax['show_in_qsp'] = 0;
					$sub_tax->save();

					$sgst_id = $sub_tax->id."-".$sub_tax['name']."-".$sub_tax['percentage'];

					$taxation['sub_tax'] = $cgst_id.",".$sgst_id;
					$taxation->save();
				}

				$item_model = $this->add('xepan\commerce\Model_Item');
				$item_model->load($form['product_id']);

				$p_item['product_id'] = $form['product_id'];
				$p_item['qty'] = $form['qty'];
				$p_item['rate'] = $form['rate'];
				$p_item['tax_id'] = $taxation->id;
				$p_item['tax_type'] = $form['tax_type'];
				$p_item['tax_percentage'] = $form['tax_percentage'];
				$p_item['qty_unit_id'] = $item_model['qty_unit_id']?$item_model['qty_unit_id']:$this->add('xepan\commerce\Model_Unit')->tryLoadAny()->get('id');

				$p_item->save();
				$crud->js(null)->reload()->execute();
			}else{
				try{
					$this->api->db->beginTransaction();
					$s_model = $this->add('xepan\commerce\Model_Supplier');
					$s_model->load($form['supplier']);

					$tnc = $this->add('xepan\commerce\Model_TNC')->addCondition('is_default_for_sale_order',true)->setLimit(1)->tryLoadAny();
					$tnc_id = $tnc->loaded()?$tnc['id']:0;
					$tnc_text = $tnc['content']?$tnc['content']:"not defined";


					$master_detail = [
						'contact_id' => $form['supplier'],
						'currency_id' => $this->app->epan->default_currency->get('id'),
						'nominal_id' => 0,
						'billing_country_id'=> $s_model['country_id'],
						'billing_state_id'=> $s_model['state_id'],
						'billing_name'=> $s_model['effective_name'],
						'billing_address'=> $s_model['address'],
						'billing_city'=> $s_model['city'],
						'billing_pincode'=> $s_model['pincode'],
						'shipping_country_id'=> $s_model['country_id'],
						'shipping_state_id'=> $s_model['state_id'],
						'shipping_name'=> $s_model['effective_name'],
						'shipping_address'=> $s_model['address'],
						'shipping_city'=> $s_model['city'],
						'shipping_pincode'=> $s_model['pincode'],
						'is_shipping_inclusive_tax'=> 0,
						'is_express_shipping'=> 0,
						'narration'=> null,
						'round_amount'=> 0,
						'discount_amount'=> 0,
						'exchange_rate' => $this->app->epan->default_currency['value'],
						'tnc_id'=>$tnc_id,
						'tnc_text'=> $tnc_text,
						'status' => "Submitted",
						'due_date'=>$this->app->nextDate($this->app->now)
					];

					$detail_data=[];
					foreach ($p_item as $i) {
						$temp = [
							'item_id'=>$i['product_id'],
							'price'=>$i['rate'],
							'quantity' => $i['qty'],
							'taxation_id' => $i['tax_id'],
							'tax_percentage' => $i['tax_percentage'],
							'narration'=>null,
							'extra_info'=>"{}",
							'shipping_charge'=>0,
							'shipping_duration'=>0,
							'express_shipping_charge'=>0,
							'express_shipping_duration'=>null,
							'qty_unit_id'=>$i['qty_unit_id']?:$this->add('xepan\commerce\Model_Unit')->tryLoadAny()->get('id'),
							'discount'=>0
						];
						$detail_data[] = $temp;
					}

					$ret = $this->add('xepan\commerce\Model_QSP_Master')->createQSP($master_detail,$detail_data,'PurchaseInvoice');
					$master = $this->add('xavoc\mlm\Model_PurchaseInvoice')->load($ret['master_detail']['id']);
					
					$company_warehouse = $this->add('xavoc\mlm\Model_Franchises')
								->addCondition('first_name','company')
								->tryLoadAny();
					if(!$company_warehouse->loaded())
						$company_warehouse->save();

			        $transaction = $company_warehouse->newTransaction($master->id,$jobcard_id=null,$from_warehouse_id=$master['contact_id'],"Purchase",$department_id=null,$to_warehouse_id=$company_warehouse->id);
			        foreach ($master->items() as $oi) {
	        			$tr_row = $transaction->addItem($oi->id,$item_id=$oi['item_id'],$oi['quantity'],$jobcard_detail_id=null,$custom_field_combination=$oi->convertCustomFieldToKey(json_decode($oi['extra_info'],true)),$status="ToReceived",$oi['item_qty_unit_id'],$oi['qty_unit_id'],true,[],$return_item_model = true);
	        			$tr_row->receive();
			        }
			  		
					$transaction['status'] = "Received";
					$transaction->save();

					$this->api->db->commit();
				}catch(\Exception $e){
					$this->api->db->rollback();
					throw $e;
				}

				$p_item->deleteAll();
				$this->js(null,$form->js()->closest('.dialog')->dialog('close'))->univ()->successMessage('Done')->execute();
			}
			$this->js()->univ()->errorMessage('final')->execute();
		}

	}

}