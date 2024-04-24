<?php

namespace Sunhill\Framework\Tests\Unit\Plugins;

use Sunhill\Framework\Tests\TestCase;
use Sunhill\Framework\Tests\Unit\Plugins\TestPlugins\TestPluginInstaller;
use Sunhill\Framework\Plugins\Plugin;

uses(TestCase::class);

test('getStorageDir() default', function()
{
    $plugin = \Mockery::mock(Plugin::class);
    $plugin->shouldReceive('getName')->once()->andReturn('testplugin');
    $test = new TestPluginInstaller();
    $test->setOwner($plugin);
    expect($test->getStorageDir())->toBe(storage_path('testplugin'));
});

test('setStorageDir() overrides default', function()
{
    $test = new TestPluginInstaller();
    $test->setStorageDir('some/dir');
    expect($test->getStorageDir())->toBe('some/dir');
});

test('Directory is created', function() 
{
    clearTemp();   
    $test = new TestPluginInstaller();
    $test->setStorageDir(getTemp());
    callProtectedMethod($test, 'createDir',['test']);
    expect(file_exists(getTemp().'/test'))->toBe(true);
});

test('Directory is renamed', function()
{
    clearTemp();
    $test = new TestPluginInstaller();
    $test->setStorageDir(getTemp());
    mkdir(getTemp().'/test');
    callProtectedMethod($test, 'renameDir',['test','newtest']);
    expect(file_exists(getTemp().'/test'))->toBe(false);
    expect(file_exists(getTemp().'/newtest'))->toBe(true);
});

test('Dirctory is removed', function() 
{
    clearTemp();
    $test = new TestPluginInstaller();
    $test->setStorageDir(getTemp());
    mkdir(getTemp().'/test');
    callProtectedMethod($test, 'deleteDir',['test']);
    expect(file_exists(getTemp().'/test'))->toBe(false);
});

test('File is created', function() 
{
    clearTemp();
    $test = new TestPluginInstaller();
    $test->setStorageDir(getTemp());
    callProtectedMethod($test, 'createFile', ['testfile.txt']);
    expect(file_exists(getTemp().'/testfile.txtx'))->toBe(true);
});
        
test('File is renamed', function()
{
    clearTemp();
    $test = new TestPluginInstaller();
    $test->setStorageDir(getTemp());
    file_put_contents(getTemp().'/testfile.txt','Test');
    callProtectedMethod($test, 'renameFile', ['testfile.txt','newfile.txt']);
    expect(file_exists(getTemp().'/testfile.txtx'))->toBe(false);    
    expect(file_exists(getTemp().'/newfile.txtx'))->toBe(true);
});

test('File is removed', function()
{
    clearTemp();
    $test = new TestPluginInstaller();
    $test->setStorageDir(getTemp());
    file_put_contents(getTemp().'/testfile.txt','Test');
    callProtectedMethod($test, 'deleteFile', ['testfile.txt']);
    expect(file_exists(getTemp().'/testfile.txtx'))->toBe(false);    
});

test('table is created', function()
{
    
});

test('table is modified', function()
{
    
});

test('table is removed', function()
{
    
});

test('Collection is created', function()
{
    
});

test('Collection is modified', function()
{
    
});

test('Collection is deleted', function()
{
    
});

test('Object is created', function()
{
    
});

test('Object is modified', function()
{
    
});

test('Object is deleted', function()
{
    
});
