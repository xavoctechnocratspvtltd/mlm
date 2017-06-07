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
        $data = [
        'Ram'=>['introducer'=>'company','side'=>'A','on'=>'2017-05-07','kit'=>'kit 1', 'green'=>'yes'],
        'Shyam'=>['introducer'=>'company','side'=>'A','on'=>'2017-05-07'],
        'Ghanshyam'=>['introducer'=>'company','side'=>'A','on'=>'2017-05-07'],
        'Gowrav'=>['introducer'=>'company','side'=>'B','on'=>'2017-05-07'],
        'Rakesh'=>['introducer'=>'ram','side'=>'A','on'=>'2017-05-07'],
        'kit-Gowrav'=>'kit 1',
        'green-Gowrav'=>'2017-05-08',
        // 'repurchase-0a'=>'total bv',
        'closing-daily'=>'2017-05-08'
        ];
        $x = $this->process($data);
        return $x;
    }

    function prepare_company_record(){
        $this->proper_responses['test_company_record']=[
            ['name'=>'Company','path'=>'0','introducer'=>null,'kit'=>null,'introAmount'=>0,'leftSv' => 0,'rightSv' => 0,'leftDP'=>0,'rightDP'=>0,'totalPairs'=>0,'carriedAmount'=>0,'greenedOn'=>null,'joinedOn'=>'2017-05-07'],
            ['name'=>'Ram','path'=>'0A','sponsor'=>'Company','introducer'=>null,'kit'=>null,'introAmount'=>0,'leftSv' => 0,'rightSv' => 0,'leftDP'=>0,'rightDP'=>0,'totalPairs'=>0,'carriedAmount'=>0,'greenedOn'=>null,'joinedOn'=>'2017-05-07'],
        ];
    }
}
