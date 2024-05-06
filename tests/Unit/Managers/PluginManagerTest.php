<?php

namespace Sunhill\Framwork\Tests\Units\Managers;

use Sunhill\Framework\Tests\TestCase;
use Sunhill\Framework\Managers\PluginManager;
use Sunhill\Framework\Plugins\Plugin;
use Sunhill\Framework\Managers\Exceptions\InvalidPlugInException;

uses(TestCase::class);

test('Read plugin directory', function() 
{
    $test = new PluginManager();
    callProtectedMethod($test, 'loadPluginsFrom', [dirname(__FILE__).'/IndependtPlugins']);
    $list = $test->getPlugins();
    expect(array_keys($list))->toBe(['ManagerPluginA','ManagerPluginB']);
    expect(is_a($list['ManagerPluginA'],Plugin::class))->toBe(true);
});

it('fails when reading wrong named plugin', function()
{
    $test = new PluginManager();
    callProtectedMethod($test, 'loadPluginsFrom', [dirname(__FILE__).'/InmvalidPluginsWrongName']);
})->throws(InvalidPlugInException::class);

it('fails when reading wrong typed plugin', function()
{
    $test = new PluginManager();
    callProtectedMethod($test, 'loadPluginsFrom', [dirname(__FILE__).'/InmvalidPluginsWrongType']);
})->throws(InvalidPlugInException::class);

it('fails when reading wrong plugin dir structure', function()
{
    $test = new PluginManager();
    callProtectedMethod($test, 'loadPluginsFrom', [dirname(__FILE__).'/InmvalidPluginsWrongStructure']);
})->throws(InvalidPlugInException::class);

