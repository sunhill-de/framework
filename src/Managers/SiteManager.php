<?php

namespace Sunhill\Framework\Managers;

use Sunhill\Framework\Modules\SkinModule;
use Sunhill\Framework\Modules\AdminModule;
use Illuminate\Support\Facades\Route;

class SiteManager 
{
    
    public function installMainmodule($module)
    {
        
    }
    
    public function installSkin(SkinModule $skin)
    {
        
    }
    
    public function installAdminModule(AdminModule $module)
    {
        
    }
    
    public function get404Error()
    {
        return view('framework::errors.error404', ['sitename'=>'Sunhill']);    
    }
    
    public function setupRoutes()
    {
        Route::fallback(function() { return $this->get404Error(); });
    }
}