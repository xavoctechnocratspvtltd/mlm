<?php


namespace xavoc\mlm;

class page_closings extends \xepan\base\Page {
	public $title= "Closings";

	function init(){
		parent::init();

		$b = $this->add('Button')->set('Closing Related Config');
		$b->add('VirtualPage')
			->bindEvent('Closing Related Config','click')
			->set(function($page){

				$c_s_m = $page->add('xepan\base\Model_ConfigJsonModel',
						[
							'fields'=>[
										'mark_green_stopped'=>'checkbox',
										'enable_closing'=>'checkbox',
										'new_registration_stopped'=>'checkbox',
										'auto_daily_closing'=>'checkbox',
										'weekly_closing_day'=>'DropDown',
										'monthly_closing_date'=>'DropDown',
									],
								'config_key'=>'CLOSING_RELATED_CONFIG',
								'application'=>'mlm'
						]);
				$c_s_m->tryLoadAny();
				
				$form = $page->add('Form');
				$form->setModel($c_s_m);
				$day_field = $form->getElement('weekly_closing_day');
				$day_field->setValueList([
							"0"=>"Sunday",
							"1"=>"Monday",
							"2"=>"Tuesday",
							"3"=>"Wednesday",
							"4"=>"Thursday",
							"5"=>"Friday",
							"6"=>"Saturday"
						]);
				$date_field = $form->getElement('monthly_closing_date');
				$date_field->setValueList([
						'01'=>'01','02'=>'02','03'=>'03','04'=>'04','05'=>'05','06'=>'06','07'=>'07','08'=>'08','09'=>'09','10'=>'10',
						'11'=>'11','12'=>'12','13'=>'13','14'=>'14','15'=>'15','16'=>'16','17'=>'17','18'=>'18','19'=>'19','20'=>'20',
						'21'=>'21','22'=>'22','23'=>'23','24'=>'24','25'=>'25','26'=>'26','27'=>'27','28'=>'28','29'=>'29','30'=>'30','31'=>'31'
					]);

				$form->addSubmit('Update');
				if($form->isSubmitted()){
					$form->save();
					$form->js(null,$form->js()->reload())->univ()->successMessage('closing config updated')->execute();
				}
		});

		$tabs = $this->add('Tabs');
		$dt = $tabs->addTab('Daily');
		$wt = $tabs->addTab('Weekly');
		$mt = $tabs->addTab('Monthly');

		$crud = $dt->add('xepan\hr\CRUD',['allow_del'=>false,'allow_edit'=>false]);
		$crud->setModel('xavoc\mlm\Model_Closing_Daily')->setOrder('on_date','desc');
		$crud->grid->removeAttachment();

		$crud = $wt->add('xepan\hr\CRUD',['allow_del'=>false,'allow_edit'=>false]);
		$crud->setModel('xavoc\mlm\Model_Closing_Weekly')->setOrder('on_date','desc');
		$crud->grid->removeAttachment();

		$crud = $mt->add('xepan\hr\CRUD',['allow_del'=>false,'allow_edit'=>false]);
		$crud->setModel('xavoc\mlm\Model_Closing_Monthly')->setOrder('on_date','desc');
		$crud->grid->removeAttachment();

	}

}