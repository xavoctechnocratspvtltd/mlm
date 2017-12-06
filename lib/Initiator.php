<?php

namespace xavoc\mlm;

class Initiator extends \Controller_Addon {
    
    public $addon_name = 'xavoc_mlm';

    function setup_admin(){
        $this->routePages('xavoc_dm');
        $this->addLocation(array('template'=>'templates','js'=>'templates/js','css'=>'templates/css'))
        ->setBaseURL('../shared/apps/xavoc/mlm/');

        $this->app->skip_accounts_ledger_creation = true;

        $m = $this->app->top_menu->addMenu('Products');
            $m->addItem(['Product Categories','icon'=>'fa fa-check-square-o'],'xavoc_dm_productcategories');
            $m->addItem(['Kit Management','icon'=>'fa fa-check-square-o'],'xavoc_dm_kits');
            $m->addItem(['Repurchase Product','icon'=>'fa fa-check-square-o'],'xavoc_dm_repurchase');
        $m = $this->app->top_menu->addMenu('Purchase');
            $m->addItem(['Supplier','icon'=>'fa fa-check-square-o'],'xavoc_dm_supplier');
            $m->addItem(['Supplier Bank Details','icon'=>'fa fa-check-square-o'],'xavoc_dm_supplier');
            $m->addItem(['Purchase','icon'=>'fa fa-check-square-o'],'xavoc_dm_productpurchase');
        
        $m = $this->app->top_menu->addMenu('Distributors');
            $m->addItem(['Distributors','icon'=>'fa fa-check-square-o'],'xavoc_dm_distributors');
            
            $m->addItem(['Red Distributors','icon'=>'fa fa-check-square-o'],'xavoc_dm_distributor_reddistributors');
            $m->addItem(['Red Distributors Other','icon'=>'fa fa-check-square-o'],'xavoc_dm_distributor_reddistributorsother');
            $m->addItem(['Red Distributors Introducer','icon'=>'fa fa-check-square-o'],'xavoc_dm_distributor_reddistributorsintroducer');
            $m->addItem(['Red Distributors Bank Report','icon'=>'fa fa-check-square-o'],'xavoc_dm_reddistributorsbank');

            $m->addItem(['Green Distributors','icon'=>'fa fa-check-square-o'],'xavoc_dm_greendistributors');
            $m->addItem(['Green Distributors Other','icon'=>'fa fa-check-square-o'],'xavoc_dm_greendistributorsother');
            $m->addItem(['Green Distributors Introducer','icon'=>'fa fa-check-square-o'],'xavoc_dm_greendistributorsintroducer');
            $m->addItem(['Green Distributors Bank Report','icon'=>'fa fa-check-square-o'],'xavoc_dm_greendistributorsbank');
            
            $m->addItem(['Verify Topup Order','icon'=>'fa fa-check-square-o'],'xavoc_dm_order_verifytopup');
            $m->addItem(['Verify Repurchase Order','icon'=>'fa fa-check-square-o'],'xavoc_dm_order_verifyrepurchase');
            $m->addItem(['Dispatch Topup Order','icon'=>'fa fa-check-square-o'],'xavoc_dm_order_delivertopup');
            $m->addItem(['Dispatch Repurchase Order','icon'=>'fa fa-check-square-o'],'xavoc_dm_order_deliverrepurchase');
            
            // $m->addItem(['Approved Orders','icon'=>'fa fa-check-square-o'],'xavoc_dm_distributors');
            $m->addItem(['Dispacthed Orders','icon'=>'fa fa-check-square-o'],'xavoc_dm_dispatchorder');
        
        $m = $this->app->top_menu->addMenu('Franchisies');
            $m->addItem(['Franchise List','icon'=>'fa fa-check-square-o'],'xavoc_dm_franchiselist');
            $m->addItem(['Franchise Orders','icon'=>'fa fa-check-square-o'],'xavoc_dm_franchiseorder');
            $m->addItem(['Franchise Movement','icon'=>'fa fa-check-square-o'],'xavoc_dm_franchisemovement');

        $m = $this->app->top_menu->addMenu('Closings');
            $m->addItem(['Closings','icon'=>'fa fa-check-square-o'],'xavoc_dm_closings');
        
        $m = $this->app->top_menu->addMenu('Store');
            // $m->addItem(['Pack/Open Joining Kits','icon'=>'fa fa-check-square-o'],'xavoc_dm_store_activity');
            // $m->addItem(['Stock Report','icon'=>'fa fa-check-square-o'],'xavoc_dm_store_activity');
            // $m->addItem(['Stock Admin Report','icon'=>'fa fa-check-square-o'],'xavoc_dm_store_activity');
            $m->addItem(['Store Activity','icon'=>'fa fa-check-square-o'],'xavoc_dm_store_activity');
            // $m->addItem(['Store Transaction','icon'=>'fa fa-check-square-o'],'xavoc_dm_storetransaction');
            // $m->addItem(['Item Stock Report','icon'=>'fa fa-check-square-o'],'xavoc_dm_itemstock');
            
        $m = $this->app->top_menu->addMenu('Report');
            $m->addItem(['Rank Report','icon'=>'fa fa-check-square-o'],'xavoc_dm_distributor_rank');
            $m->addItem(['TopUp & Repurchase History','icon'=>'fa fa-check-square-o'],'xavoc_dm_report_sale');

        $m = $this->app->top_menu->addMenu('Admin');
            $m->addItem(['Recent Distributors News','icon'=>'fa fa-check-square-o'],'xavoc_dm_recentnews');
            $m->addItem(['Recent Website News','icon'=>'fa fa-check-square-o'],'xavoc_dm_recentwebsitenews');
            $m->addItem(['Gallery','icon'=>'fa fa-check-square-o'],'xavoc_dm_gallery');
            $m->addItem(['Download','icon'=>'fa fa-check-square-o'],'xavoc_dm_download');
            $m->addItem(['Configuration','icon'=>'fa fa-check-square-o'],'xavoc_dm_config');
            $m->addItem(['Set Date','icon'=>'fa fa-check-square-o'],'xavoc_dm_setdate');
            $m->addItem(['Post','icon'=>'fa fa-sitemap'],$this->app->url('xepan_hr_post',['status'=>'Active']));
            $m->addItem(['Employee','icon'=>'fa fa-male'],$this->app->url('xepan_hr_employee',['status'=>'Active']));
            $m->addItem(['User','icon'=>'fa fa-user'],$this->app->url('xepan_hr_user',['status'=>'Active']));
            $m->addItem(['Manage Banks','icon'=>'fa fa-user'],$this->app->url('xavoc_dm_banks',['status'=>'Active']));
            $m->addItem(['ACL','icon'=>'fa fa-dashboard'],'xepan_hr_aclmanagement');


        $this->addAppFunctions();

        $this->app->addHook('invoice_paid',function($app,$invoice){
            $distributor = $this->add('xavoc\mlm\Model_Distributor');
            $distributor->load($invoice['contact_id']);
            $total_bv = 0;
            $total_sv = 0;
            foreach ($invoice->items() as $oi) {
                $item = $this->add('xavoc\mlm\Model_Item')->load($oi['item_id']);
                if($item['is_package']){
                    // if kit then update SV
                    $distributor->purchaseKit($item['id']);
                    $distributor->markGreen();
                    // $distributor->updateAnsestorsSV($item['sv']);
                }else{
                    $total_bv += $item['bv']*$oi['quantity'];
                    $total_sv += $item['sv']*$oi['quantity'];
                }
            }
            if($total_bv > 0 || $total_sv > 0)
                $distributor->repurchase($total_bv,$total_sv);
        });

        $this->app->js(true)->_selector('#page-wrapper')->addClass('nav-small');

        return $this;
    }

    function addAppFunctions(){
        
        
    }

    function setup_pre_frontend(){
        $this->routePages('xavoc_dm');
        $this->addLocation(array('template'=>'templates','js'=>'templates/js','css'=>['templates/css','templates/js']))
        ->setBaseURL('./shared/apps/xavoc/mlm/');

        return $this;

    }

    function setup_frontend(){

        $this->app->skip_accounts_ledger_creation = true;

        $this->app->addHook('login_panel_user_loggedin',function($app,$user){            
            $f_model = $this->add('xavoc\mlm\Model_Franchises');
            $f_model->loadLoggedIn('Warehouse');
            if($f_model->loaded())
                $this->app->redirect($this->app->url('franchises_dashboard'));

            $m = $this->add('xavoc\mlm\Model_Distributor');
            $m->loadLoggedIn('Customer');
            if($m->loaded()){
                $this->app->redirect($this->app->url('dashboard'));
            }            

        });
        
        $this->app->addHook('invoice_paid',function($app,$invoice){
            $distributor = $this->add('xavoc\mlm\Model_Distributor');
            $distributor->load($invoice['contact_id']);
            $total_bv = 0;
            $total_sv = 0;
            foreach ($invoice->items() as $oi) {
                $item = $this->add('xavoc\mlm\Model_Item')->load($oi['item_id']);
                if($item['is_package']){
                    // if kit then update SV
                    $distributor->purchaseKit($item['id']);
                    $distributor->markGreen();
                    // $distributor->updateAnsestorsSV($item['sv']);
                }else{
                    $total_bv += $item['bv']*$oi['quantity'];
                    $total_sv += $item['sv']*$oi['quantity'];
                }
            }
            if($total_bv > 0 || $total_sv > 0)
                $distributor->repurchase($total_bv,$total_sv);
        });


        $now = \DateTime::createFromFormat('Y-m-d H:i:s', $this->app->now);
        // $closing_m = $this->add('xavoc\mlm\Model_Closing')
        //                 ->setOrder('id','desc')
        //                 ->tryLoadAny();

        // $date = $this->app->my_date_diff($this->app->now,$closing_m['on_date']); 
        // if($date['days'] > 1) {
            $cron = new \Cron\Job\ShellJob();
            // $cron->setSchedule(new \Cron\Schedule\CrontabSchedule('* * * * *'));
            $cron->setSchedule(new \Cron\Schedule\CrontabSchedule('0 0 * * *'));
            if(!$cron->getSchedule() || $cron->getSchedule()->valid($now)){
                echo "going for daily auto closing </br>";
                $this->add('xavoc\mlm\Controller_AutoDailyClosing');              
            }
        // }
        
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
        $this->app->exportFrontEndTool('xavoc\mlm\Tool_RepurchaseItem','MLM');
        $this->app->exportFrontEndTool('xavoc\mlm\Tool_Profile','MLM');
        $this->app->exportFrontEndTool('xavoc\mlm\Tool_MenuBar','MLM');
        $this->app->exportFrontEndTool('xavoc\mlm\Tool_DistributorMenu','MLM');
        $this->app->exportFrontEndTool('xavoc\mlm\Tool_MyOrder','MLM');
        $this->app->exportFrontEndTool('xavoc\mlm\Tool_GenerationTree','MLM');
        $this->app->exportFrontEndTool('xavoc\mlm\Tool_FranchisesMenu','MLM');
        $this->app->exportFrontEndTool('xavoc\mlm\Tool_FranchisesDashboard','MLM');
        $this->app->exportFrontEndTool('xavoc\mlm\Tool_FranchisesOrder','MLM');
        $this->app->exportFrontEndTool('xavoc\mlm\Tool_FranchisesDispatch','MLM');
        $this->app->exportFrontEndTool('xavoc\mlm\Tool_FranchisesVerifyOrder','MLM');
        $this->app->exportFrontEndTool('xavoc\mlm\Tool_FranchisesSetting','MLM');
        $this->app->exportFrontEndTool('xavoc\mlm\Tool_FranchisesStock','MLM');
        $this->app->exportFrontEndTool('xavoc\mlm\Tool_DistributorCheckout','MLM');
        $this->app->exportFrontEndTool('xavoc\mlm\Tool_DistributorReport','MLM');
        $this->app->exportFrontEndTool('xavoc\mlm\Tool_Utility','MLM');
        $this->app->exportFrontEndTool('xavoc\mlm\Tool_RecentWebsiteNews','MLM');
        return $this;
    }
}
