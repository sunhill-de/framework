<?php

namespace Sunhill\Framework\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Sunhill\Basic\SunhillBasicServiceProvider;
use Sunhill\Framework\SunhillFrameworkServiceProvider;

class TestCase extends Orchestra
{
    
    protected function getPackageProviders($app)
    {
        return [
            SunhillFrameworkServiceProvider::class
        ];    
    }
    
}
