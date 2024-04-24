<?php

namespace Sunhill\Framework\Plugins;

use IsaEken;
use Sunhill\Framework\Plugins\Exceptions\WrongInstallersFormatException;

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
    
    protected $installers = [];
    
    /**
     * Checks if the installers are in an expected format
     */
    protected function checkInstallers()
    {
        if (!is_array($this->installers)) {
           throw new WrongInstallersFormatException("The installers are not an array");
        }        
    }

    /**
     * Returns all installers that match a given criteria
     * 
     * @param string $relation
     * @param string $version
     * @return unknown[]
     */
    protected function getInstallers(string $relation, string $version)
    {
        $result = [];
        foreach ($this->installers as $inst_version => $installer) {
            if (version_compare($inst_version, $version, $relation)) {
                $result[] = $installer;
            }
        }
        return $result;
    }
    
    /**
     * Executes a list of installers
     * 
     * @param array $list
     */
    protected function executeInstallers(array $list)
    {
        foreach ($list as $installer) {
            if (is_string($installer) && (class_exists($installer))) {
                $installer = new $installer();
            };
            if (is_a($installer, PluginInstaller::class)) {
                $installer->execute();
            } else {
               throw new WrongInstallersFormatException("The given installer is not a PluginInstaller"); 
            }
        }
    }
    
    public function install()
    {
        $this->checkInstallers();
        $this->executeInstallers($this->getInstallers('=','0'));
    }
    
    public function uninstall()
    {
        $this->checkInstallers();        
        $this->executeInstallers($this->getInstallers('=','-1'));
    }
    
    public function upgrade(string $from)
    {
        $this->checkInstallers();        
        $this->executeInstallers($this->getInstallers('>',$from));
    }

    protected $dependencies = [];
    
    public function getDependencies(): array
    {
        return $this->dependencies;
    }
}