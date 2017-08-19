<?php


namespace xavoc\mlm;

class page_greendistributorsbank extends \xepan\base\Page {
	public $title= "Green Distributors Bank";

	function page_index(){
		$form = $this->add('Form');
		$form->setLayout('view/form/distributor-filter');
		$form->addField('line','search');
		$form->addField('DatePicker','from_date');
		$form->addField('DatePicker','to_date');
		$form->addSubmit('Filter')->addClass('btn btn-primary');

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

		if($search = $this->app->stickyGET('search')){
			$model->addCondition([['name',$search],['email',$search],['mobile_number',$search],['user',$search]]);
		}

		$grid = $this->add('xepan\base\Grid');
		$grid->setModel($model,['greened_on','user','name','city','bank_name','d_account_number','d_account_type','d_bank_ifsc_code']);
		$grid->add('xepan\hr\Controller_ACL',['status_color'=>$status_color]);

		$grid->addPaginator($ipp=50);
		$grid->removeColumn('attachment_icon');
		$grid->addSno('Sr.No');

		if($form->isSubmitted()){
			$grid->js()->reload(['search'=>$form['search'],'from_date'=>$form['from_date']?:0,'to_date'=>$form['to_date']?:0])->execute();
		}	
	}
}