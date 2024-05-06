<?php

namespace Sunhill\Framework\Managers;

use Illuminate\Support\Facades\Config;

class PluginManager 
{

    protected $plugins = [];
    
    protected function loadPluginsFrom(string $dir)
    {
        
    }
    
    protected function checkDependencies()
    {
        
    }
    
    protected function bootPlugins()
    {
        
    }
    
    public function setupPlugins()
    {
        $this->loadPluginsFrom(Config::get('plugin_dir',base_path('/plugins')));
        $this->checkDependencies();
        $this->bootPlugins();
    }
    
    public function query()
    {
        
    }
    
}