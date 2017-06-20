<?php

namespace xavoc\mlm;

class Initiator extends \Controller_Addon {
    
    public $addon_name = 'xavoc_mlm';

    function setup_admin(){
        $this->routePages('xavoc_dm');
        $this->addLocation(array('template'=>'templates','js'=>'templates/js','css'=>'templates/css'))
        ->setBaseURL('../shared/apps/xavoc/mlm/');

        $m = $this->app->top_menu->addMenu('Direct Marketing');
        // $m->addItem(['Pin Management','icon'=>'fa fa-check-square-o'],'xavoc_dm_distributors');
        $m->addItem(['Kit Management','icon'=>'fa fa-check-square-o'],'xavoc_dm_kits');
        $m->addItem(['Distributors','icon'=>'fa fa-check-square-o'],'xavoc_dm_distributors');
        $m->addItem(['Closings','icon'=>'fa fa-check-square-o'],'xavoc_dm_closings');
        $m->addItem(['Configuration','icon'=>'fa fa-check-square-o'],'xavoc_dm_config');

        $this->addAppFunctions();

        return $this;
    }

    function addAppFunctions(){
        
        
    }

    function setup_pre_frontend(){
        $this->routePages('xavoc_dm');
        $this->addLocation(array('template'=>'templates','js'=>'templates/js','css'=>'templates/css'))
        ->setBaseURL('./shared/apps/xavoc/mlm/');

        return $this;

    }

    function setup_frontend(){

       $this->app->addHook('login_panel_user_loggedin',function($app,$user){
            $m = $this->add('xavoc\mlm\Model_Distributor');
            $m->loadLoggedIn();
            if($m->loaded()){
                $this->app->redirect($this->app->url('dashboard'));
            }
       });
        
        $this->app->exportFrontEndTool('xavoc\mlm\Tool_Register','MLM');
      
        $this->app->exportFrontEndTool('xavoc\mlm\Tool_DashBoard','MLM');
        $this->app->exportFrontEndTool('xavoc\mlm\Tool_Distributor','MLM');
        $this->app->exportFrontEndTool('xavoc\mlm\Tool_WareHouse','MLM');
        $this->app->exportFrontEndTool('xavoc\mlm\Tool_Genology','MLM');
        $this->app->exportFrontEndTool('xavoc\mlm\Tool_Wallet','MLM');
        $this->app->exportFrontEndTool('xavoc\mlm\Tool_ClosingAndPayouts','MLM');
        $this->app->exportFrontEndTool('xavoc\mlm\Tool_MyAccount','MLM');
        $this->app->exportFrontEndTool('xavoc\mlm\Tool_Register','MLM');
        $this->app->exportFrontEndTool('xavoc\mlm\Tool_Kit','MLM');
        $this->app->exportFrontEndTool('xavoc\mlm\Tool_Profile','MLM');
        $this->app->exportFrontEndTool('xavoc\mlm\Tool_MenuBar','MLM');
        $this->app->exportFrontEndTool('xavoc\mlm\Tool_DistributorMenu','MLM');
        $this->app->exportFrontEndTool('xavoc\mlm\Tool_MyOrder','MLM');
        return $this;
    }
}
