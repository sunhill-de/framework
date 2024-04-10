<?php

namespace Sunhill\Framework\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Sunhill\Framework\SunhillFrameworkServiceProvider;
use Sunhill\Basic\SunhillBasicServiceProvider;

class TestCase extends Orchestra
{
    
    protected function getPackageProviders($app)
    {
        return [
            SunhillFrameworkServiceProvider::class,
            SunhillBasicServiceProvider::class,
            \Sunhill\Properties\SunhillPropertiesServiceProvider::class
        ];    
    }
    
}
