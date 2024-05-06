<?php

namespace Sunhill\Framwork\Tests\Units\Managers;

use Sunhill\Framework\Tests\TestCase;
use Sunhill\Framework\Managers\PluginManager;
use Sunhill\Framework\Plugins\Plugin;
use Sunhill\Framework\Managers\Exceptions\InvalidPlugInException;
use Sunhill\Framework\Plugins\PluginQuery;
use Sunhill\Framework\Managers\Exceptions\UnmatchedPluginDependencyException;

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

test('query() calls PluginQuery', function()
{
    $test = new PluginManager();
    expect(is_a($test->querty()), PluginQuery::class)->toBe(true);
});

test('Dependencies match', function()
{
   $test = new PluginManager();
   $pluginA = \Mockery::mock(Plugin::class);
   $pluginA->shouldReceive('getName')->andReturn('PluginA');
   $pluginA->shouldReceive('getDependencies')->andReturn(['PluginB']);
   $pluginB = \Mockery::mock(Plugin::class);
   $pluginB->shouldReceive('getName')->andReturn('PluginB');
   $pluginB->shouldReceive('getDependencies')->andReturn(['PluginA']);
   $test->setPlugins(['PluginA'=>$pluginA,'PluginB'=>$pluginB]);
   
   callProtectedMethod($test, 'checkDependencies');
   expect(true)->toBe(true); // Sorry, but checkDependecies just must not throw something
});

it('Dependencies mismatch', function()
{
    $test = new PluginManager();
    $pluginA = \Mockery::mock(Plugin::class);
    $pluginA->shouldReceive('getName')->andReturn('PluginC');
    $pluginA->shouldReceive('getDependencies')->andReturn(['PluginB']);
    $pluginB = \Mockery::mock(Plugin::class);
    $pluginB->shouldReceive('getName')->andReturn('PluginB');
    $pluginB->shouldReceive('getDependencies')->andReturn(['PluginA']);
    $test->setPlugins(['PluginA'=>$pluginA,'PluginB'=>$pluginB]);
    
    callProtectedMethod($test, 'checkDependencies');
})->throws(UnmatchedPluginDependencyException::class);

test('Boot plugins', function()
{
    $test = new PluginManager();
    $pluginA = \Mockery::mock(Plugin::class);
    $pluginA->shouldReceive('boot')->once();
    $pluginB = \Mockery::mock(Plugin::class);
    $pluginB->shouldReceive('boot')->once();
    $test->setPlugins(['PluginA'=>$pluginA,'PluginB'=>$pluginB]);

    callProtectedMethod($test, 'bootPlugins');
    expect(true)->toBe(true); // Sorry, but checkDependecies just must not throw something
});


