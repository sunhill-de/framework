<?php

namespace Sunhill\Framework\Plugins;

use IsaEken;

class Plugin extends IsaEken\PluginSystem\Plugin
{
    
    public function handle(...$arguments): mixed
    {
        return true;
    }
    
}