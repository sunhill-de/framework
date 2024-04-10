<?php
/**
 * @file FeatureModule.php
 * Provides the basic class for all feature modules
 * Lang en
 * Reviewstatus: 2024-04-08
 * Localization:
 * Documentation:
 * Tests:
 * Coverage: unknown
 * PSR-State: complete
 */

namespace Sunhill\Framework\Modules;

use Sunhill\Framework\Response\AbstractResponse;
use Sunhill\Framework\Traits\NameAndDescription;

/**
 * This class is a base class for a feature modules. A feature module is a collection of logical
 * functions (like manipulating an item) and can be mounted into the module tree of the application.
 * 
 * @author klaus
 *
 */
class FeatureModule extends AbstractModule
{
        
    public function addSubmodule(FeatureModule $module, ?callable $callback = null): FeatureModule
    {
        
    }
    
    public function addResponse(AbstractResponse $response): AbstractResponse
    {
        
    }
    
    public function defaultIndex(): AbstractModule
    {
        
    }
    
    public function addIndex(AbstractResponse $response): AbstractModule
    {
        
    }
    
    public function getBreadcrumbs()
    {
        if    
    }
}