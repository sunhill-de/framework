<?php

use Sunhill\Framework\Tests\TestCase;
use Sunhill\Framework\Modules\FeatureModules\FeatureModule;

uses(TestCase::class);

test('Breadcrumbs works', function() {
   $parent = new FeatureModule();
   $parent->setName('parent');
   $parent->setDescription('parent module');

   $child = new FeatureModule();
   $child->setName('child');
   $child->setDescription('child module');
   $child->setOwner($parent);
   
   $breadcrumbs = $child->getBreadcrumbs();
   expect(array_keys($breadcrumbs))->toBe(['/parent/','/parent/child/']);
   expect(array_values($breadcrumbs))->toBe(['parent module','child module']);
});