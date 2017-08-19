<?php

namespace xavoc\mlm;

class Tool_FranchisesOrder extends \xepan\cms\View_Tool{
	public $options = [];

	function init(){
		parent::init();
		
		if($this->owner instanceof \AbstractController) return;

		$this->franchises = $franchises = $this->add('xavoc\mlm\Model_Franchises');
		$franchises->loadLoggedIn();
		
		$this->addClass('main-box');
		$this->app->stickyGET('distributor_id');
		$this->app->stickyGET('r_dist_id');

		$tab = $this->add('Tabs');
		$topup_tab = $tab->addTab('Topup/Re-Topup');
		$repurchase_tab = $tab->addTab('Repurchase');

		// $item = $this->add('xepan\commerce\Model_Item');
		$item = $this->add('xavoc\mlm\Model_Kit');
		$item->getElement('pv')->destroy();
		$item->getElement('bv')->destroy();
		$item->getElement('sv')->destroy();
		$item->getElement('introducer_income')->destroy();
		$item->getElement('dp')->destroy();

		$item->addExpression('capping_int')->set(function($m,$q){
			return $q->expr('CAST([0] AS SIGNED)',[$m->getElement('capping')]);
		});

		$item->title_field = "kit_with_price";
		$item->addExpression('kit_with_price')->set(function($m,$q){
			return $q->expr('CONCAT([0]," :: ",[1]," ::",[2])',
									[
										$m->getElement('name'),
										$m->getElement('sku'),
										$m->getElement('sale_price')
									]
				);
		});

		$dist = $this->add('xavoc\mlm\Model_Distributor');
		$dist->title_field = 'user';
		
		$form = $topup_tab->add('Form');
		$dist_field = $form->addField('autocomplete/Basic','distributor')->validate('required');
		$dist_field->setModel($dist);
		
		$kit_field = $form->addField('Dropdown','kit')->validate('required');
		$kit_field->setModel($item);
		$kit_field->setEmptyText('Please select');

		$form->addField('text','payment_narration')->validate('required');
		$form->addField('line','delivery_via')->validate('required');
		$form->addField('line','delivery_docket_no','Docket no/ Person name/ Other reference');
		$form->addField('line','tracking_code');

		$tax_detail = $form->add('View');
		// autocomplete reload
		// $kit_field->send_other_fields = [$dist_field];
		
		$reload_field_array[] = $form->js()->atk4_form(
								'reloadField','kit',[
										$this->app->url(),
											'dist_id'=>$dist_field->js()->val()
										]
								);
		$dist_field->other_field->js('change',$reload_field_array);
		if($_GET['dist_id']){
			$last_kit = $this->add('xavoc\mlm\Model_TopupHistory')
				->addCondition('distributor_id',$_GET['dist_id'])
				->setOrder('id','desc')
				->tryLoadAny();
			$last_capping = 0;
			if($last_kit->loaded())
				$last_capping = $last_kit['capping'];

			$kit_field->getModel()->addCondition('capping_int','>',$last_capping);
			if($kit_field->getModel()->count()->getOne() == 0){
				$kit_field->setFieldHint('no more topup are found for selected distributor');
			}
		}

		$kit_field->js('change',$tax_detail->js()->reload(['selected_kit_id'=>$kit_field->js()->val()]));
		if($_GET['selected_kit_id']){
			$im = $this->add('xavoc\mlm\Model_Item')->load($_GET['selected_kit_id']);
			$tax_array = $im->getTaxAmount($this->franchises->id);
			
			$html_tax_detail = '<table style="width:100%;">';
			$html_tax_detail .= "<tr>";
			$html_tax_detail .= "<td>Base Amount: </td>";
			$html_tax_detail .= "<td>".$tax_array['base_amount']."</td>";
			$html_tax_detail .= "</tr>";
			
			$html_tax_detail .= "<tr>";
			$html_tax_detail .= "<td>GST Amount: <br/>@".$tax_array['tax_percentage']."% </td>";
			$html_tax_detail .= "<td>".$tax_array['tax_amount']."</td>";
			$html_tax_detail .= "</tr>";

			// sub tax detail table
			$html_tax_detail .= "<tr><td colspan='2'>";
				$sub_table = '<table>';
				if($tax_array['tax_apply' == 'igst']){
					$sub_table .= "<tr>";
					$sub_table .= "<td>CGST: <br/>@".$tax_array['cgst_amount']."%</td>";
					$sub_table .= "<td>".$tax_array['cgst_amount']."</td>";
					$sub_table .= "</tr>";

					$sub_table .= "<tr>";
					$sub_table .= "<td>SGST: <br/>@".$tax_array['sgst_percentage']."%</td>";
					$sub_table .= "<td>".$tax_array['sgst_amount']."</td>";
					$sub_table .= "</tr>";
				}else{
					$sub_table .= "<tr>";
					$sub_table .= "<td>IGST: <br/>@".$tax_array['igst_percentage']."%</td>";
					$sub_table .= "<td>".$tax_array['igst_amount']."</td>";
					$sub_table .= "</tr>";
				}
				$sub_table .= '</table>';
			$html_tax_detail .= $sub_table;
			$html_tax_detail .= "</td></tr>";

			$html_tax_detail .= "<tr>";
			$html_tax_detail .= "<td>Net Amount: </td>";
			$html_tax_detail .= "<td>".$tax_array['net_amount']."</td>";
			$html_tax_detail .= "</tr>";

			$html_tax_detail .= '</table>';

			$tax_detail->setHtml($html_tax_detail);
		}

		// // autocomplete reload
		// if($dist_id = $_GET['o_'.$dist_field->name]){
		// 	$last_kit = $this->add('xavoc\mlm\Model_TopupHistory')
		// 		->addCondition('distributor_id',$dist_id)
		// 		->setOrder('id','desc')
		// 		->tryLoadAny();
		// 	$last_capping = 0;
		// 	if($last_kit->loaded())
		// 		$last_capping = $last_kit['capping'];

		// 	$kit_field->getModel()->addCondition('capping_int','>',$last_capping);
		// }

		$form->addSubmit('Topup Now')->addClass('btn btn-primary');
		
		if($form->isSubmitted()){

			try{

				$this->app->db->beginTransaction();

				$distributor = $this->add('xavoc\mlm\Model_Distributor')->load($form['distributor']);

				$result = $distributor->placeTopupOrder($form['kit'],$this->franchises->id);
				$order_id = $result['master_detail']['id'];
				
				$payment_detail['payment_narration'] = $form['payment_narration'];
				$payment_detail['is_payment_verified'] = true;

				$distributor->purchaseKit($form['kit']);
				$distributor->updateTopupHistory($form['kit'],$order_id,"deposite_in_franchies",$payment_detail);
				
				$order_model = $this->add('xavoc\mlm\Model_SalesOrder');
				$order_model->load($order_id);
				$order_model->invoice()->paid();

				$order_model->dispatchComplete($this->franchises->id,[
						'delivery_via'=>$form['delivery_via'],
						'delivery_docket_no'=>$form['delivery_docket_no'],
						'tracking_code'=>$form['tracking_code'],
						'narration' => $form['payment_narration']
					]);
				
				$this->app->db->commit();
			}catch(Exception $e){
				$this->app->db->rollback();
				throw $e;
			}

			$form->js(null,$form->js()->reload())->univ()->successMessage('distributor topuped successfully')->execute();
		}


		// repurchase
		$repurchase_tab->add('xavoc\mlm\View_FranchisesRepurchase');


	}
}