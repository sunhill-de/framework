<?php

use Sunhill\Framework\Traits\Owner;
use Sunhill\Framework\Traits\Children;

uses(\Sunhill\Framework\Tests\TestCase::class);

class DummyChildrenObject {
    
    use Children;
    
    public $name;
    
    public function getName()
    {
        return $this->name;
    }
    
    public $owner;
    
    public function setOwner($owner)
    {
        $this->owner = $owner;
    }
}

test('Add child works', function() {
    $parent = new DummyChildrenObject();
    $parent->name = 'parent';
    $child1 = new DummyChildrenObject();
    $child1->name = 'child1';
    $child2 = new DummyChildrenObject();
    $child2->name = 'child2';
    expect($parent->hasChildren())->toBe(false);
    $parent->addChild('child1',$child1);
    $parent->addChild('child2',$child2);
    expect($parent->hasChildren())->toBe(true);
});

test('parent is added as owner', function() {
    $parent = new DummyChildrenObject();
    $parent->name = 'parent';
    $child1 = new DummyChildrenObject();
    $child1->name = 'child1';
    $parent->addChild('child1',$child1);
    
    expect($child1->owner)->toBe($parent);
});

test('Flush children works', function() {
        $parent = new DummyChildrenObject();
        $parent->name = 'parent';
        $child1 = new DummyChildrenObject();
        $child1->name = 'child1';
        $child2 = new DummyChildrenObject();
        $child2->name = 'child2';
        $parent->addChild('child1',$child1);
        $parent->addChild('child2',$child2);
        $parent->flushChildren();
        
        expect($parent->hasChildren)->toBe(false);
});

test('Delete child works', function() {
        $parent = new DummyChildrenObject();
        $parent->name = 'parent';
        $child1 = new DummyChildrenObject();
        $child1->name = 'child1';
        $child2 = new DummyChildrenObject();
        $child2->name = 'child2';
        $parent->addChild('child1',$child1);
        $parent->addChild('child2',$child2);
        expect($parent->hasChild('child1'))->toBe(true);
        $parent->deleteChild('child1');
        expect($parent->hasChild('child1'))->toBe(false);        
});

test('Get child works', function() {
        $parent = new DummyChildrenObject();
        $parent->name = 'parent';
        $child1 = new DummyChildrenObject();
        $child1->name = 'child1';
        $child2 = new DummyChildrenObject();
        $child2->name = 'child2';
        $parent->addChild('child1',$child1);
        $parent->addChild('child2',$child2);
        expect($parent->getChild('child1'))->toBe($child1);
});