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

namespace Sunhill\Framework\Modules\FeatureModules;

use Sunhill\Framework\Response\AbstractResponse;
use Sunhill\Framework\Traits\NameAndDescription;
use Sunhill\Framework\Modules\AbstractModule;
use Sunhill\Framework\Modules\Exceptions\CantProcessModuleException;

/**
 * This class is a base class for a feature modules. A feature module is a collection of logical
 * functions (like manipulating an item) and can be mounted into the module tree of the application.
 * 
 * @author klaus
 *
 */
class FeatureModule extends AbstractModule
{
   
    protected function doAddSubmodule(FeatureModule $module)
    {
        
    }
    
    public function addSubmodule($module, ?callable $callback = null): FeatureModule
    {
        if (is_a($module, FeatureModule::class)) {
            $this->doAddSubmodule($module);
        } else if (is_string($module) && class_exists($mdoule)) {
            $module = new $module();
            $this->doAddSubmodule($module);
        } else {
            throw new CantProcessModuleException("The passed parameter can't be processed to a module");
        }
        if (!is_null($callback)) {
            $callback($module);
        }
        return $module;
    }
    
    public function addResponse($response): AbstractResponse
    {
        
    }
    
    public function defaultIndex(): AbstractModule
    {
        
    }
    
    public function addIndex(AbstractResponse $response): AbstractModule
    {
        
    }
    
    /**
     * Returns the breadcrumbs array. Ths array is an associative array which keys are the link 
     * and its values are the description of the module
     * @return string
     */
    public function getBreadcrumbs()
    {
        if ($this->hasOwner()) {
            $result = $this->getOwner()->getBreadcrumbs();
        } else {
            $result = [];
        }
        $result[$this->getPath()] = $this->getDescription();
        return $result;
    }
}