<?php


namespace xavoc\mlm;

class page_greendistributorsother extends \xepan\base\Page {
	public $title= "Green Distributors other";

	function page_index(){
		
		$form = $this->add('Form');
		$form->setLayout('view/form/distributor-filter');
		$form->addField('line','user');
		$form->addField('line','name');
		$form->addField('line','mobile');
		$form->addField('line','city');
		$form->addField('line','state');
		$form->addField('DatePicker','from_date');
		$form->addField('DatePicker','to_date');
		$form->addField('DatePicker','dob');
		$form->addSubmit('Filter')->addClass('btn btn-primary');

		$status_color = [
						'Red'=>'danger',
						'KitSelected'=>'default',
						'KitPaid'=>'primary',
						'Green'=>'success'
					];
		
		$model = $this->add('xavoc\mlm\Model_Distributor_Actions');

		$model->addCondition('status','Green');
		
		if($fd = $this->app->stickyGET('from_date')){
			$model->addCondition('greened_on','>=',$fd);
		}

		if($td = $this->app->stickyGET('to_date')){
			$model->addCondition('greened_on','<',$this->app->nextDate($td));
		}

		if($search = $this->app->stickyGET('user')){
			$model->addCondition('user','like','%'.$search.'%');
		}

		if($search = $this->app->stickyGET('name')){
			$model->addCondition('name','like','%'.$search.'%');
		}
		if($search = $this->app->stickyGET('mobile')){
			$model->addCondition('mobile_number','like','%'.$search.'%');
		}
		if($search = $this->app->stickyGET('city')){
			$model->addCondition('city','like','%'.$search.'%');
		}

		if($search = $this->app->stickyGET('state')){
			$model->addCondition('state','like','%'.$search.'%');
		}
		
		if($search = $this->app->stickyGET('dob')){
			$model->addCondition('dob',$search);
		}

		$model->getElement('created_at')->type('date')->sortable(true);
		$model->setOrder('created_at','desc');

		$grid = $this->add('xepan\base\Grid');
		$grid->setModel($model,['greened_on','user','name','city','pan_no','dob','email']);
		$grid->add('xepan\hr\Controller_ACL',['status_color'=>$status_color]);

		$grid->addPaginator($ipp=50);
		$grid->removeColumn('attachment_icon');
		$grid->addSno('Sr.No',true);

		if($form->isSubmitted()){
			$grid->js()->reload(['user'=>$form['user'],'name'=>$form['name'],'mobile'=>$form['mobile'],'city'=>$form['city'],'state'=>$form['state'],'from_date'=>$form['from_date']?:0,'to_date'=>$form['to_date']?:0,'dob'=>$form['dob']?:0])->execute();
		}	
	}
}