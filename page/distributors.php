<?php


namespace xavoc\mlm;

class page_distributors extends \xepan\base\Page {
	public $title= "All Distributors";

	function init(){
		parent::init();

		$status_color = [
						'Red'=>'danger',
						'KitSelected'=>'default',
						'KitPaid'=>'primary',
						'Green'=>'success'
					];
		
		$grid = $this->add('xepan\hr\Grid',['status_color'=>$status_color]);
		$model= $this->add('xavoc\mlm\Model_Distributor_Actions');
		// $model->getElement('organization')->caption('SUPPLIER FIRM NAME');

		$grid->setModel($model,['created_at','user','name','city','mobile_number']);
		$grid->addQuickSearch(['name','user','mobile_number']);
		$grid->addSno('Sr. No',true);

		$grid->addPaginator(50);
		$grid->add('xepan\hr\Controller_ACL',['status_color'=>$status_color]);
		$grid->removeAttachment();

		$grid->add('xavoc\mlm\View_Export');
	}

}