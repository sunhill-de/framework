<?php

namespace Sunhill\Framework\Traits;

trait Children 
{
    
    protected array $children = [];

    public function addChild(string $name, $child)
    {
        $this->children[$name] = $child;
        $child->setOwner($this);
        return $this;
    }
    
    public function hasChildren(): bool
    {
        return !empty($this->children);
    }
    
    public function flushChildren()
    {
        $this->children = [];
    }
    
    public function hasChild(string $name)
    {
        return isset($this->children[$name]);
    }
    
    public function getChild(string $name)
    {
        if (isset($this->children[$name])) {
            return $this->children[$name];
        }
        throw FrameworkException("There is no child named '$name'");
    }
    
    public function deleteChild(string $name)
    {
        if (isset($this->children[$name])) {
            unset($this->children[$name]);
        } else {
            throw FrameworkException("There is no child named '$name'");
        }
    }
}