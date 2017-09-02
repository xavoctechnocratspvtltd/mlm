<?php


namespace xavoc\mlm;

class page_distributor_rank extends \xepan\base\Page {
	public $title= "Distributor Rank";

	function page_index(){
		
		$this->app->stickyGET('distributor');
		
		$auto_m = $this->add('xavoc\mlm\Model_Distributor');
		$auto_m->title_field = 'user';

		$form = $this->add('Form');
		$form->add('xepan\base\Controller_FLC')
			->layout([
					'distributor'=>'Search Under Distributor~c1~8',
					'FormButtons~'=>'c2~4'
				]);
		$form->addField('autocomplete/Basic','distributor')->validate('required')->setModel($auto_m);
		$form->addSubmit('Get List')->addClass('btn btn-primary btn-block');

		$dist_m = $this->add('xavoc\mlm\Model_RePurchaseBonusSlab');

		$dist_m->addExpression('count_distributors')->set(function($m,$q){
			$t = $m->add('xavoc\mlm\Model_Distributor')
						->addCondition('current_rank_id',$q->getField('id'));
			
			if($_GET['distributor']){
				$t_d = $this->add('xavoc\mlm\Model_Distributor')->load($_GET['distributor']);
				$t->addCondition('path','like',$t_d['path'].'_%');
			}
			

			return $t->count();
		});


		$grid = $this->add('xepan\base\Grid');

		if($_GET['distributor']){
			$grid->add('H3',null,'grid_buttons')->set('Rank Users under : '.$t_d = $this->add('xavoc\mlm\Model_Distributor')->load($_GET['distributor'])->get('name'));
		}

		$grid->setModel($dist_m,['name','count_distributors']);
		$grid->addTotals(['count_distributors']);
		$grid->addPaginator(100);

		$grid->addFormatter('count_distributors','template')->setTemplate('<a href="#" class="count-details" data-rank_id="{$id}"> {$count_distributors} </a>','count_distributors');

		if($form->isSubmitted()){
			$grid->js()->reload(['distributor'=>$form['distributor']])->execute();
		}


		$grid->js('click')->_selector('.count-details')->univ()->frameURL('Distributors',[$this->app->url('./list'),'rank_id'=>$this->js()->_selectorThis()->data('rank_id')]);
		
	}

	function page_list(){

		$rank_id = $this->app->stickyGET('rank_id');
		$parent_distributor_id =$this->app->stickyGET('distributor');

		$d_m = $this->add('xavoc\mlm\Model_Distributor');
		
		if($rank_id){
			$d_m->addCondition('current_rank_id',$rank_id);
		}

		if($parent_distributor_id){
			$p_d_m = $this->add('xavoc\mlm\Model_Distributor')->load($_GET['distributor']);
			$d_m->addCondition('path','like',$p_d_m['path'].'_%');
		}

		$grid = $this->add('xepan\base\Grid');
		$grid->setModel($d_m,['name','user','sponsor','introducer','created_at','greened_on']);
		$grid->addPaginator(50);

		$grid->addQuickSearch(['name','user']);

	}


}