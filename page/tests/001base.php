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
        'A'=>['introducer'=>'0','side'=>'A','on'=>'2017-05-07','kit'=>'Package B1', 'green'=>'yes'],
        'B'=>['introducer'=>'0','side'=>'B','on'=>'2017-05-07','kit'=>'Package C1', 'green'=>'yes'],
        'A1'=>['introducer'=>'A','side'=>'A','on'=>'2017-05-07','kit'=>'Package D1','green'=>'yes'],
        'A2'=>['introducer'=>'A','side'=>'B','on'=>'2017-05-07','kit'=>'Package D1','green'=>'yes'],
        'C'=>['introducer'=>'0','side'=>'A','on'=>'2017-05-07','kit'=>'Package A1','green'=>'yes'],
        'C1'=>['introducer'=>'C','side'=>'A','on'=>'2017-05-07','kit'=>'Package B1','green'=>'yes'],
        'C2'=>['introducer'=>'C','side'=>'B','on'=>'2017-05-07','kit'=>'Package C1','green'=>'yes'],
        'A3'=>['introducer'=>'A','side'=>'A','on'=>'2017-05-07','kit'=>'Package D1','green'=>'yes'],
        'D'=>['introducer'=>'B','side'=>'A','on'=>'2017-05-07','kit'=>'Package D1','green'=>'yes'],
        'E'=>['introducer'=>'0','side'=>'B','on'=>'2017-05-07','kit'=>'Package C1','green'=>'yes'],
        'A31'=>['introducer'=>'A3','side'=>'A','on'=>'2017-05-07'],
        'A32'=>['introducer'=>'A3','side'=>'B','on'=>'2017-05-07'],
        'repurchase-A31-1'=>'10000',
        'repurchase-A32-1'=>'5000',
        'repurchase-C2-1'=>'15000',
        'repurchase-D-1'=>'20000',
        'kit-0'=>'Package B1',
        'green-0'=>'2017-05-08',


        // 'Rakesh'=>['introducer'=>'Ghanshyam','side'=>'A','on'=>'2017-05-07'],
        // 'repurchase-Rakesh-1'=>'120',
        // 'kit-Gowrav'=>'Package C1',
        // 'green-Gowrav'=>'2017-05-08',
        // 'repurchase-Gowrav'=>'240',
        // 'repurchase-Ram-1'=>'16000',
        // 'repurchase-Rakesh-2'=>'1000',
        // 'closing-monthly-1'=>'2017-05-08',
        // 'repurchase-Ghanshyam-2'=>'136000',
        // 'ShyamIntro2'=>['introducer'=>'Shyam','side'=>'A','on'=>'2017-06-01'],
        // 'GowravIntro1'=>['introducer'=>'Gowrav','side'=>'B','on'=>'2017-06-01'],
        // 'kit-ShyamIntro2'=>'Package A1',
        // 'kit-GowravIntro1'=>'Package C1',
        // 'green-ShyamIntro2'=>'2017-06-02',
        // 'green-GowravIntro1'=>'2017-06-02',
        'closing-daily'=>'2017-05-08',
        'closing-weekly'=>'2017-05-08',
        'closing-monthly-2'=>'2017-05-18'
        ];
        $x = $this->process($data,'test_company_record');
        return $x;
    }

    function prepare_company_record(){
        $this->proper_responses['test_company_record']=[
            ['0'=>['d.path'=>'0B','d.month_self_bv'=>0,'p.carried_amount'=>null]]
        ];
    }
}
