<?php
/**
 * @file PluginInstaller.php
 * A basic class for plugin installers
 * Lang en
 * Reviewstatus: 2024-04-22
 * Localization:
 * Documentation:
 * Tests:
 * Coverage: unknown
 * PSR-State: complete
 */

namespace Sunhill\Framework\Plugins;

abstract class PluginInstaller
{
     
    protected $plugin = '';
    
    /**
     * Getter for $plugin
     * 
     * @return string
     */
    public function getPlugin(): string
    {
        return $this->plugin;
    }
    
    protected $version = '';
    
    /**
     * Getter for $version
     * 
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }
    
    /**
     * Does the installation/upgrade process
     */
    abstract public function execute();
    
    protected function createDir(string $name)
    {
        
    }
    
    protected function renameDir(string $from, string $to)
    {
        
    }
    
    protected function deleteDir(string $name)
    {
        
    }
}