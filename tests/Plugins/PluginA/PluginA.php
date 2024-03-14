<?php

use Sunhill\Framework\Plugins\Plugin;

require(dirname(__FILE__).'/src/ModuleA.php');
require(dirname(__FILE__).'/src/ModuleB.php');

class PluginA extends Plugin
{
    
    public function boot()
    {
        $moduleA = new ModuleA();
        $moduleB = new ModuleB();
        return 'Boot:'.$moduleA->doSomething().$moduleB->doSomething();
    }
}