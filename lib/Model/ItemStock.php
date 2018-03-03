<?php

namespace xavoc\mlm;

class Model_ItemStock extends \xepan\commerce\Model_Item_Stock {
	public $table_alias = 'dm_item_stock';

	function init(){
		parent::init();

		$this->getElement('net_stock')->destroy();

		$this->addExpression('name_with_code')->set(function($m,$q){
			return $q->expr('CONCAT([0]," :: ",[1])',
									[
										$m->getElement('name'),
										$m->getElement('sku')
									]
				);
		});

		$this->addExpression('total_in')->set(function($m,$q){
			return $q->expr('([opening]+[purchase]+[adjustment_add]+[movement_in]+[issue_submitted]+[sales_return]+[package_created]+[release_from_package])',
							[
								'opening'  				=>  $m->getElement('opening'),
								'purchase' 				=> 	$m->getElement('purchase'),
								// 'received' 				=> 	$m->getElement('received'),
								'adjustment_add' 		=> 	$m->getElement('adjustment_add'),
								'movement_in' 			=>	$m->getElement('movement_in'),
								'issue_submitted'		=> 	$m->getElement('issue_submitted'),
								'sales_return'			=> 	$m->getElement('sales_return'),
								'package_created' 		=>	$m->getElement('package_created'),
								'release_from_package'	=>	$m->getElement('release_from_package')
							]);
		});

		$this->addExpression('total_out')->set(function($m,$q){			
			return $q->expr('([purchase_return]+[consumption_booked]+[consumed]+[adjustment_removed]+[movement_out]+[issue]+[shipped]+[delivered]+[package_opened]+[consumed_in_package])',
							[
								'purchase_return'		=>	$m->getElement('purchase_return'),
								'consumption_booked'	=>	$m->getElement('consumption_booked'),
								'consumed' 				=>	$m->getElement('consumed'),
								'adjustment_removed'	=>	$m->getElement('adjustment_removed'),
								'movement_out' 			=>	$m->getElement('movement_out'),
								'issue' 				=>	$m->getElement('issue'),
								'shipped' 				=>	$m->getElement('shipped'),
								'delivered' 			=>	$m->getElement('delivered'),
								'package_opened' 		=>	$m->getElement('package_opened'),
								'consumed_in_package'	=>	$m->getElement('consumed_in_package'),
							]);
		});

		$this->addExpression('net_stock')->set(function($m,$q){
			return $q->expr('[0] - [1]',[$m->getElement('total_in'),$m->getElement('total_out')]);
		});


	}
} 