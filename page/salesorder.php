<?php 
 namespace xavoc\mlm;
 class page_salesorder extends \xepan\base\Page{

	public $title='Sales Orders';

	function init(){
		parent::init();

		$customer_id = $this->app->stickyGET('customer_id');

		$saleorder = $this->add('xavoc\mlm\Model_SalesOrder');
		
		if($customer_id)
			$saleorder->addCondition('contact_id',$customer_id);

		$saleorder->setOrder('id','desc');
		$saleorder->add('xepan\commerce\Controller_SideBarStatusFilter');

		$saleorder->add('misc/Field_Callback','net_amount_client_currency')->set(function($m){
			return $m['exchange_rate'] == '1'? "": ($m['net_amount'].' '. $m['currency']);
		});

		$saleorder->addExpression('contact_name',function($m,$q){
			return $m->refSQL('contact_id')->fieldQuery('name');
		});
		$saleorder->addExpression('contact_organization_name',function($m,$q){
			return $m->refSQL('contact_id')->fieldQuery('organization');
		});

		$saleorder->addExpression('organization_name',function($m,$q){
			return $q->expr('IF(ISNULL([organization_name]) OR trim([organization_name])="" ,[contact_name],[organization_name])',
						[
							'contact_name'=>$m->getElement('contact_name'),
							'organization_name'=>$m->getElement('contact_organization_name')
						]
					);
		});

		$saleorder->addExpression('inv_no',function($m,$q){
			// return "'0'";
			// return $q->getField('id');

			return $q->expr("(select GROUP_CONCAT(document_no) from qsp_master where related_qsp_master_id=[0])",[$q->getField('id')]);
			// $m1= $m->add('xepan\commerce\Model_SalesInvoice',['table_alias'=>'acdf']);
			// $m1->addCondition('related_qsp_master_id',$q->getField('id'));
			// return $m1->_dsql()->del('fields')->field($q->expr('GROUP_CONCAT([0])',[$m1->getElement('document_no')]))->group($q->getField('id'));
		});

		$saleorder->addExpression('sales_invoice_id',function($m,$q){
			return $q->expr("(select GROUP_CONCAT(document_id) from qsp_master where related_qsp_master_id=[0])",[$q->getField('id')]);
			// return "'0'";
			// $m1 = $m->add('xepan\commerce\Model_SalesInvoice',['table_alias'=>'cdfd']);
			// $m1->addCondition('related_qsp_master_id',$q->getField('id'));
			// return $m1->_dsql()->del('fields')->field($q->expr('GROUP_CONCAT([0])',[$m->getElement('id')]))->group($q->getField('id'));

		});

		$saleorder->addExpression('contact_type',$saleorder->refSQL('contact_id')->fieldQuery('type'));

		$crud=$this->add('xepan\hr\CRUD',
						['action_page'=>'xepan_commerce_quickqsp&document_type=SalesOrder']
						,null,
						['view/order/sale/grid']);
		
		$crud->grid->addHook('formatRow',function($g){
			if($g->model['from'] == 'Online')
				$g->current_row['online_icon']= "fa-shopping-cart";
		});

		$crud->setModel($saleorder);
		$crud->grid->addPaginator(50);
		$frm=$crud->grid->addQuickSearch(['document_no','contact_name','organization_name']);
		
		$crud->add('xepan\base\Controller_Avatar',['name_field'=>'contact']);
		$crud->add('xepan\base\Controller_MultiDelete');

		if(!$crud->isEditing()){
			$crud->grid->js('click')->_selector('.do-view-frame')->univ()->frameURL('Sales Order Details',[$this->api->url('xepan_commerce_salesorderdetail'),'document_id'=>$this->js()->_selectorThis()->closest('[data-salesorder-id]')->data('id')]);
			$crud->grid->js('click')->_selector('.do-view-customer-frame')->univ()->frameURL('Customer Details',[$this->api->url('xepan_commerce_customerdetail'),'contact_id'=>$this->js()->_selectorThis()->closest('[data-contact-id]')->data('contact-id')]);
			$crud->grid->js('click')->_selector('.order-invoice-number')->univ()->frameURL('Invoice Detail',[$this->api->url('xepan_commerce_salesinvoicedetail'),'document_id'=>$this->js()->_selectorThis()->data('salesinvoice-id')]);
		}
	}
}  
