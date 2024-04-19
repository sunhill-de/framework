<?php

namespace Sunhill\Framework\Plugins;

use IsaEken;

class Plugin extends IsaEken\PluginSystem\Plugin
{
    
    /**
     * Array of strings that stores the features of this plugin
     * 
     * @var array
     */
    protected $provides = [];
    
    /**
     * Tests if the given plugin has a certain feature
     * 
     * @param string $feature
     * @return bool
     */
    public function doesProvide(string $feature): bool
    {
        return in_array($feature, $this->provides);    
    }
    
    /**
     * Manually adds a feature to this module, normally this shouldn't be necessary because every pluigin should
     * know what features it provides
     * 
     * @param string $feature
     * @return self
     */
    public function addFeature(string $feature): self
    {
        $this->provides[] = $feature;
        return $this;
    }
    
    public function handle(...$arguments): mixed
    {
        return true;
    }
    
}