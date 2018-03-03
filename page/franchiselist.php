<?php


namespace xavoc\mlm;

class page_franchiselist extends \xepan\base\Page {
	public $title= "Franchises List";

	function page_index(){

		$franch_model = $this->add('xavoc\mlm\Model_Franchises');
		$crud = $this->add('xepan\hr\CRUD');
		$form = $crud->form;
		$form->add('xepan\base\Controller_FLC')
			->showLables(true)
			->makePanelsCoppalsible(true)
			->layout([
					'first_name~'=>'Franchises Detail~c1~4',
					'country_id~Country'=>'c2~4',
					'state_id~State'=>'c3~4',
					'address'=>'c4~4',
					'city'=>'c5~4',
					'pin_code'=>'c6~4',
					'emails'=>'c7~12',
					'mobile_nos'=>'c8~12'
				]);

		if($crud->isEditing()){
			$form = $crud->form;
			$form->addField('mobile_nos');
			$form->addField('emails');

			$crud->addHook('formSubmit',function($c,$cf){
				$cf->model->set($cf->getAllFields());
				$cf->model->save();

				$cf->model->deleteContactEmails();
				$cf->model->deleteContactPhones();

				if(trim($cf['mobile_nos'])){
					$nos = explode(",", $cf['mobile_nos']);
					foreach ($nos as $no){
						if(!trim($no)) continue;
						$cf->model->addPhone($no,$head='Official',$active=true,$valid=true,null,$validate=true);
					}
				}

				if(trim($cf['emails'])){
					$nos = explode(",", $cf['emails']);
					foreach ($nos as $no) {
						if(!trim($no)) continue;
						$cf->model->addEmail($no,$head='Official',$active=true,$valid=true,null,$validate=true);
					}
				}

				return true; // do not proceed with default crud form submit behaviour
			});
		}

		$crud->setModel($franch_model,
						['first_name','country_id','state_id','address','city','pin_code','status'],
						['first_name','country','state','','address','city','pin_code','status']
					);

		if($crud->isEditing()){
			$form = $crud->form;
			$country_field = $form->getElement('country_id');
			$country_field->getModel()->addCondition('status','Active');

			$state_field = $form->getElement('state_id');
			if($_GET['country_id']){
				$state_field
					->getModel()
					->addCondition('country_id',$_GET['country_id'])
					->addCondition('status','Active')
					;
			}else{
				$state_field
					->getModel()
					->addCondition('country_id',100)
					->addCondition('status','Active')
					;// india
			}
			$country_field->js('change',$state_field->js()->reload(null,null,[$this->app->url(null,['cut_object'=>$state_field->name]),'country_id'=>$country_field->js()->val()]));
		}

		if($crud->isEditing('edit')){
			$crud->form
				->getElement('mobile_nos')
				->set($crud->model['contacts_comma_seperated']);

			$crud->form
				->getElement('emails')
				->set(str_replace("<br/>", ",",$crud->model['emails_str']));
		}

		$crud->grid->removeColumn('attachment_icon');


	}
}