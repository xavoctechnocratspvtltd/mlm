<?php


namespace xavoc\mlm;

class page_distributor_reddistributorsintroducer extends \xepan\base\Page {
	public $title= "Red Distributors Introducers";

	function page_index(){
		$form = $this->add('Form');
		$form->addField('DatePicker','from_date');
		$form->addField('DatePicker','to_date');
		$form->addSubmit('Filter');

		$status_color = [
						'Red'=>'danger',
						'KitSelected'=>'default',
						'KitPaid'=>'primary',
						'Green'=>'success'
					];
		
		$model = $this->add('xavoc\mlm\Model_Distributor_Actions');

		$model->addCondition('status','Red');
		if($fd = $this->app->stickyGET('from_date')){
			$model->addCondition('created_at','>',$fd);
		}

		if($td = $this->app->stickyGET('to_date')){
			$model->addCondition('created_at','<',$this->app->nextDate($td));
		}

		$grid = $this->add('xepan\base\Grid');
		$grid->setModel($model,['created_at','user','name','city','introducer','sponsor']);
		$grid->add('xepan\hr\Controller_ACL',['status_color'=>$status_color]);

		$grid->addPaginator($ipp=50);
		$grid->removeColumn('attachment_icon');
		$grid->addSno('Sr.No');

		if($form->isSubmitted()){
			$grid->js()->reload(['from_date'=>$form['from_date']?:0,'to_date'=>$form['to_date']?:0])->execute();
		}	
	}
}