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

class page_tests_001base extends page_Tester {
	
	public $title='Base Testing';
	
	public $proper_responses=[''];

    public $user;
    public $on_date;

    function init(){
        // Before tests run
        parent::init();
    }

    function test_company_record(){
        $this->resetData();
        $data = [
        'Ram'=>['introducer'=>'0','side'=>'B','on'=>'2017-05-07'],
        'Shyam'=>['introducer'=>'0','side'=>'B','on'=>'2017-05-07'],
        'Ghanshyam'=>['introducer'=>'Ram','side'=>'B','on'=>'2017-05-07'],
        'Gowrav'=>['introducer'=>'Shyam','side'=>'A','on'=>'2017-05-07'],
        'Rakesh'=>['introducer'=>'Ghanshyam','side'=>'A','on'=>'2017-05-07'],
        'repurchase-Rakesh'=>'120',
        'repurchase-Gowrav'=>'240',
        // 'repurchase-Ram'=>'12000',
        // 'repurchase-Rakesh'=>'10000',
        // 'closing-daily'=>'2017-05-08'
        // 'closing-weekly'=>'2017-05-08'
        // 'closing-monthly'=>'2017-07-08'
        ];
        $x = $this->process($data,'test_company_record');
        return $x;
    }

    function prepare_company_record(){
        $this->proper_responses['test_company_record']=[
            ['Ram'=>['d.path'=>'0A','d.month_self_bv'=>120,'p.carried_amount'=>1250]]
        ];
    }
}
