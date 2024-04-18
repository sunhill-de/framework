<?php

namespace Sunhill\Framework\Managers;

use IsaEken\PluginSystem\Interfaces\PluginInterface;
use IsaEken\PluginSystem\PluginSystem;
use Illuminate\Support\Facades\Config;

class PluginManager 
{
    
    protected $plugin_system;
    
    public function setupPlugins()
    {
        $this->plugin_system = new PluginSystem();
        $this->plugin_system->load(Config::get('plugin_dir',base_path('/plugins')));
        return $this->plugin_system->execute('boot');
    }
    
    public function query()
    {
        
    }
    
}