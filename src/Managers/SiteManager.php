<?php

namespace Sunhill\Framework\Managers;

use Sunhill\Framework\Modules\SkinModule;
use Sunhill\Framework\Modules\AdminModule;
use Illuminate\Support\Facades\Route;

class SiteManager 
{
    
    protected $main_module;
    
    public function installMainmodule($module)
    {
        $this->main_module = $module;
        return $module;
    }
    
    public function flushMainmodule()
    {
        unset($this->main_module);
    }
    
    public function installSkin(SkinModule $skin)
    {
        
    }
    
    public function installAdminModule(AdminModule $module)
    {
        
    }
    
    public function get404Error()
    {
        return view('framework::errors.error404', ['sitename'=>env('APP_NAME','Sunhill')]);    
    }
    
    public function setupRoutes()
    {
        Route::fallback(function() { return $this->get404Error(); });
    }
}