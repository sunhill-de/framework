<?php

use Sunhill\Framework\Traits\Owner;

uses(\Sunhill\Framework\Tests\TestCase::class);

class DummyOwnerObject {
    
    use Owner;
    
    public $name;
    
    public function getName()
    {
        return $this->name;
    }
    
}

test('Setter and getter works', function() {
   $parent = new DummyOwnerObject();
   $parent->name = 'parent';
   $child = new DummyOwnerObject();
   $child->name = 'child';
   
   $child->setOwner($parent);
   expect($child->getOwner())->toBe($parent);
   expect($child->hasOwner())->toBe(true);
   expect($parent->hasOwner())->toBe(false);
});

test('Get hirarchy works', function() {
    $parent = new DummyOwnerObject();
    $parent->name = 'parent';
    $child = new DummyOwnerObject();
    $child->name = 'child';
    
    $child->setOwner($parent);
    
    $hirarchy = $child->getHirachy();
    $keys = array_keys($hirarchy);
    expect($keys)->toBe(['parent','child']);
    expect($hirarchy['parent'])->toBe($parent);
});