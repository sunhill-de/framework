<?php
/**
 * @file AbstractModule.php
 * Provides the basic class for all other modules
 * Lang en
 * Reviewstatus: 2024-04-08
 * Localization:
 * Documentation:
 * Tests:
 * Coverage: unknown
 * PSR-State: complete
 */

namespace Sunhill\Framework\Modules;

/**
 * The class defines the rudimental functions that each module should share. That is
 * naming and hirarchy
 * @author lokal
 *
 */
class AbstractModule
{

    /**
     * The current name of this module
     * 
     * @var string
     */
    protected $name = '';
    
    /**
     * Setter for name
     * 
     * @param string $name
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }
    
    /**
     * Getter for name
     * 
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
    
    /**
     * The owning module of this module (or null if top)
     * @var AbstractModule
     */
    protected AbstractModule $owner;
    
    /**
     * Setter for owner
     * 
     * @param AbstractModule $owner
     * @return self
     */
    public function setOwner(AbstractModule $owner): self
    {
        $this->owner = $owner;
        return $this;
    }
    
    /**
     * Getter for owner
     * 
     * @return AbstractModule
     */
    public function getOwner(): AbstractModule
    {
        return $this->owner;
    }
    
    /**
     * Returns if the module has an owner 
     * 
     * @return bool
     */
    public function hasOwner(): bool
    {
        return !is_null($this->owner);    
    }
    
    /**
     * Returns an associative array with the name of the module as key and a reference to the
     * module as value
     * 
     * @return array
     */
    public function getHirachy(): array
    {
        if ($this->hasOwner()) {
            $result = [];
        } else {
            $result = $this->getOwner()->getHirarchy();
        }
        $result[$this->getName()] = $this;
        
        return $result;
    }
}