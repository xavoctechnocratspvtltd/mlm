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
        'Ram'=>['introducer'=>'company','side'=>'A','on'=>'2017-05-07','kit'=>'Package A1', 'green'=>'yes'],
        'Shyam'=>['introducer'=>'company','side'=>'A','on'=>'2017-05-07'],
        'Ghanshyam'=>['introducer'=>'company','side'=>'A','on'=>'2017-05-07'],
        'Gowrav'=>['introducer'=>'company','side'=>'B','on'=>'2017-05-07'],
        'Rakesh'=>['introducer'=>'Ram','side'=>'A','on'=>'2017-05-07'],
        'kit-0'=>'Package A1',
        'kit-Ram'=>'Package A1',
        'green-0'=>'2017-05-08',
        'green-Ram'=>'2017-05-08',
        'kit-Gowrav'=>'Package A1',
        'green-Gowrav'=>'2017-05-08',
        'repurchase-Gowrav'=>'120',
        'repurchase-Ram'=>'12000',
        'repurchase-Rakesh'=>'10000',
        // 'closing-daily'=>'2017-05-08'
        // 'closing-weekly'=>'2017-05-08'
        'closing-monthly'=>'2017-05-08'
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
