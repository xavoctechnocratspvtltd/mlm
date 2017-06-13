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
        $this->resetData(true);
        $data = [
        // Company => 0,
        'Ram'=>['introducer'=>'0','side'=>'B','on'=>'2017-05-07','kit'=>'Package A1', 'green'=>'yes'],
        'Shyam'=>['introducer'=>'0','side'=>'B','on'=>'2017-05-07','kit'=>'Package A1', 'green'=>'yes'],
        'Ghanshyam'=>['introducer'=>'Ram','side'=>'B','on'=>'2017-05-07','kit'=>'Package B1','green'=>'yes'],
        'Gowrav'=>['introducer'=>'Shyam','side'=>'A','on'=>'2017-05-07'],
        'Rakesh'=>['introducer'=>'Ghanshyam','side'=>'A','on'=>'2017-05-07'],
        'kit-0'=>'Package A1',
        'green-0'=>'2017-05-08',
        'repurchase-Rakesh'=>'120',
        'kit-Gowrav'=>'Package C1',
        'green-Gowrav'=>'2017-05-08',
        'repurchase-Gowrav'=>'240',
        'repurchase-Ram-1'=>'36000',
        'repurchase-Rakesh'=>'1000',
        'closing-monthly-1'=>'2017-05-08',
        'repurchase-Ram-2'=>'36000',
        // 'ShyamIntro2'=>['introducer'=>'Shyam','side'=>'A','on'=>'2017-06-01'],
        // 'GowravIntro1'=>['introducer'=>'Gowrav','side'=>'B','on'=>'2017-06-01'],
        // 'kit-ShyamIntro2'=>'Package A1',
        // 'kit-GowravIntro1'=>'Package C1',
        // 'green-ShyamIntro2'=>'2017-06-02',
        // 'green-GowravIntro1'=>'2017-06-02',
        // 'closing-daily'=>'2017-05-08'
        'closing-monthly-2'=>'2017-05-18'
        ];
        $x = $this->process($data,'test_company_record');
        return $x;
    }

    function prepare_company_record(){
        $this->proper_responses['test_company_record']=[
            ['Ram'=>['d.path'=>'0B','d.month_self_bv'=>0,'p.carried_amount'=>null]]
        ];
    }
}
