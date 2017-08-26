<?php


namespace xavoc\mlm;

class page_greendistributorsintroducer extends \xepan\base\Page {
	public $title= "Green Distributors Introducer";

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
		$c1= $c->addColumn(4)->addClass('col-sm-12 col-md-4')->addField('line','intro_id');
		$c2= $c->addColumn(4)->addClass('col-sm-12 col-md-4')->addField('line','intro_name');
		$c3= $c->addColumn(4)->addClass('col-sm-12 col-md-4')->addField('line','sponsor_id','placement parent id');
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

		if($search = $this->app->stickyGET('intro_id')){
			$model->addExpression('intro_id')->set(function($m,$q){
				return $m->refSQL('introducer_id')
						->fieldQuery('user');
			});
			$model->addCondition('intro_id','like','%'.$search.'%');
		}

		if($search = $this->app->stickyGET('intro_name')){
			$model->addExpression('intro_name')->set(function($m,$q){
				return $m->refSQL('introducer_id')
						->fieldQuery('name');
			});
			$model->addCondition('intro_name','like','%'.$search.'%');
		}

		if($search = $this->app->stickyGET('sponsor_id')){
			$model->addExpression('sponsor_user')->set(function($m,$q){
				return $m->refSQL('sponsor_id')
						->fieldQuery('user');
			});
			$model->addCondition('sponsor_user','like','%'.$search.'%');
		}

		$model->getElement('created_at')->type('date')->sortable(true);
		$model->setOrder('created_at','desc');

		$grid = $this->add('xepan\base\Grid');
		$grid->setModel($model,['greened_on','user','name','city','introducer','sponsor','side']);
		$grid->add('xepan\hr\Controller_ACL',['status_color'=>$status_color]);

		$grid->addPaginator($ipp=50);
		$grid->removeColumn('attachment_icon');
		$grid->addSno('Sr.No',true);

		if($form->isSubmitted()){
			$grid->js()->reload(['user'=>$form['user'],'name'=>$form['name'],'mobile'=>$form['mobile'],'city'=>$form['city'],'state'=>$form['state'],'from_date'=>$form['from_date']?:0,'to_date'=>$form['to_date']?:0,'intro_id'=>$form['intro_id'],'intro_name'=>$form['intro_name'],'sponsor_id'=>$form['sponsor_id']])->execute();
		}		
	}
}