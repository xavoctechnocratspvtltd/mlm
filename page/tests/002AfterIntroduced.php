<?php

/**
* description: ATK Page
* 
* @author : Gowrav Vishwakarma
* @email : gowravvishwakarma@gmail.com, info@xavoc.com
* @website : http://xepan.org
* 
*/

namespace xavoc\mlm;

class page_tests_002AfterIntroduced extends page_Tester {
	
	public $title='After Introduced Before Closing';
	
	public $proper_responses=[''];

    public $user;
    public $on_date;

    function init(){
        // Before tests run
        parent::init();
    }

    function test_company_record_after_introduced(){
        $this->resetData();
        $data = [
        // Company => 0,
        'Ram'=>['introducer'=>'0','side'=>'A','on'=>'2017-05-11','kit'=>'Package A1','green'=>'yes'],
        'Shyam'=>['introducer'=>'0','side'=>'B','on'=>'2017-05-11','kit'=>'Package B1','green'=>'yes'],
        // 'Ghanshyam'=>['introducer'=>'Ram','side'=>'B','on'=>'2017-05-07','kit'=>'Package B1','green'=>'yes'],
        // 'Gowrav'=>['introducer'=>'Shyam','side'=>'A','on'=>'2017-05-07'],
        // 'Rakesh'=>['introducer'=>'Ghanshyam','side'=>'A','on'=>'2017-05-07'],
        // 'repurchase-Rakesh'=>'120',
        // 'repurchase-Gowrav'=>'240',
        // 'repurchase-Ram'=>'12000',
        // 'repurchase-Rakesh'=>'10000',
        // 'closing-daily'=>'2017-05-08'
        // 'closing-weekly'=>'2017-05-08'
        // 'closing-monthly'=>'2017-07-08'
        ];
        $x = $this->process($data,'test_company_record_after_introduced');
        return $x;
    }

    function prepare_company_record(){
        $this->proper_responses['test_company_record_after_introduced']=[
            ['Company'=>['d.path'=>'0','d.weekly_intros_amount'=>200,'p.carried_amount'=>null]],
            ['Ram'=>['d.path'=>'0A','d.month_self_bv'=>0,'p.carried_amount'=>null]],
            ['Shyam'=>['d.path'=>'0B','d.month_self_bv'=>0,'p.carried_amount'=>null]]
        ];
    }
}
