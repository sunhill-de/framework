<?php

namespace Sunhill\Framework\Managers;

use IsaEken\PluginSystem\Interfaces\PluginInterface;
use IsaEken\PluginSystem\PluginSystem;

class PluginManager 
{
    
    protected $plugin_system;
    
    public function setupPlugins()
    {
        $this->plugin_system = new PluginSystem(base_path('/plugins'));
        $this->plugin_system->autoload();
    }
    
}