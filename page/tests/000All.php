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

class page_tests_000All extends page_Tester {
	
	public $title='All Complete with multi case';
	
	public $proper_responses=[''];

    public $user;
    public $on_date;

    function init(){
        $this->resetData(true);
        // Before tests run
        parent::init();
    }

    function test_company_introduced(){
        $data = [
        // Company => 0,
        'Company'=>['kit'=>'Package A1','green'=>'yes'],
        'Ram'=>['introducer'=>'0','side'=>'A','on'=>'2017-05-11','kit'=>'Package A1','green'=>'yes'],
        'Shyam'=>['introducer'=>'0','side'=>'B','on'=>'2017-05-11','kit'=>'Package B1','green'=>'yes']
        ];
        $x = $this->process($data,'test_company_introduced');
        return $x;
    }

    function prepare_company_introduced(){
        $this->proper_responses['test_company_introduced']=[
            ['Company'=>['d.path'=>'0','d.weekly_intros_amount'=>200,'p.introduction_amount'=>null]],
            ['Ram'=>['d.path'=>'0A','d.weekly_intros_amount'=>0,'d.month_self_bv'=>0,'p.carried_amount'=>null]],
            ['Shyam'=>['d.path'=>'0B','d.weekly_intros_amount'=>0,'d.month_self_bv'=>0,'p.carried_amount'=>null]]
        ];
    }

    function test_company_first_closing(){
        $data = [
            'closing-monthly'=>'2017-07-31'
        ];
        $x = $this->process($data,'test_company_first_closing');
        return $x;
    }

    function prepare_company_first_closing(){
        $this->proper_responses['test_company_first_closing']=[
            ['Company'=>['d.path'=>'0','d.weekly_intros_amount'=>0,'p.introduction_amount'=>200]],
            ['Ram'=>['d.path'=>'0A','d.weekly_intros_amount'=>0,'d.month_self_bv'=>0,'p.carried_amount'=>0.00]],
            ['Shyam'=>['d.path'=>'0B','d.weekly_intros_amount'=>0,'d.month_self_bv'=>0,'p.carried_amount'=>0.00]]
        ];
    }


}
