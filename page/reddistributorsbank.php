<?php


namespace xavoc\mlm;

class page_reddistributorsbank extends \xepan\base\Page {
	public $title= "Red Distributors Bank";

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
		$c = $form->layout->add('Columns')->addClass('row');
		$c1= $c->addColumn(6)->addClass('col-sm-12 col-md-6')->addField('line','bank_name');
		$c2= $c->addColumn(6)->addClass('col-sm-12 col-md-6')->addField('line','ifsc');
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

		if($search = $this->app->stickyGET('bank_name')){
			$model->addCondition('d_bank_name','like','%'.$search.'%');
		}

		if($search = $this->app->stickyGET('ifsc')){
			$model->addCondition('d_bank_ifsc_code','like','%'.$search.'%');
		}

		$model->getElement('created_at')->type('date')->sortable(true);
		$model->setOrder('created_at','desc');

		$grid = $this->add('xepan\base\Grid');
		$grid->setModel($model,['created_at','user','name','city','d_bank_name','d_account_number','d_account_type','d_bank_ifsc_code','mobile_number']);
		$grid->add('xepan\hr\Controller_ACL',['status_color'=>$status_color]);

		$grid->addPaginator($ipp=50);
		$grid->removeColumn('attachment_icon');
		$grid->addSno('Sr.No',true);
		$grid->add('xavoc\mlm\View_Export');
		
		if($form->isSubmitted()){
			$grid->js()->reload(['user'=>$form['user'],'name'=>$form['name'],'mobile'=>$form['mobile'],'city'=>$form['city'],'state'=>$form['state'],'from_date'=>$form['from_date']?:0,'to_date'=>$form['to_date']?:0,'bank_name'=>$form['bank_name'],'ifsc'=>$form['ifsc']])->execute();
		}		
	}
}