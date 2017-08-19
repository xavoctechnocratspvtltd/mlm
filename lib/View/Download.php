<?php

namespace xavoc\mlm;
class View_Download extends \View{

	function init(){
		parent::init();

		$download = $this->add('xavoc\mlm\Model_Download');
		$download->addCondition('status','Active');
		$download->setOrder('id','desc');

		$grid = $this->add('xepan\base\Grid');

		$grid->addHook('formatRow',function($g){
			$g->current_row_html['description'] = $g->model['description'];

			$g->current_row_html['image'] = '<a href="'.$g->model['image'].'"download>Download</a><br/><a target="_blank" href="'.$g->model['image'].'">View</a>';
		});

		$grid->setModel($download);
		$grid->addPaginator(25);
		$grid->addSno('Sr. No.');
		$grid->addQuickSearch(['name','description']);
	}
}