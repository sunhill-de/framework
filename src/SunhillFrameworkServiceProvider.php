<?php

namespace Sunhill\Framework;

use Illuminate\Support\ServiceProvider;
use Sunhill\Framework\Managers\PluginManager;
use Sunhill\Framework\Facades\Plugins;

class SunhillFrameworkServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(PluginManager::class, function () { return new PluginManager(); } );
        $this->app->alias(PluginManager::class,'plugins');
    }
    
    public function boot()
    {
        Plugins::setupPlugins();
    }
}
