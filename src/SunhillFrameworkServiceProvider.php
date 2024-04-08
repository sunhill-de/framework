<?php

namespace Sunhill\Framework;

use Illuminate\Support\ServiceProvider;
use Sunhill\Framework\Managers\PluginManager;
use Sunhill\Framework\Facades\Plugins;
use Sunhill\Framework\Managers\SiteManager;

class SunhillFrameworkServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(PluginManager::class, function () { return new PluginManager(); } );
        $this->app->alias(PluginManager::class,'plugins');
        $this->app->singleton(SiteManager::class, function () { return new SiteManager(); } );
        $this->app->alias(SiteManager::class,'site');
    }
    
    public function boot()
    {
        Plugins::setupPlugins();
        
        $this->loadViewsFrom(__DIR__.'/../resources/views','visual');
        
    }
}
