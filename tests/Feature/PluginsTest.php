<?php

uses(\Sunhill\Properties\Tests\TestCase::class);
use Illuminate\Support\Facades\Config;
use Sunhill\Framework\Managers\PluginManager;


test('boot', function () {
    Config::set('plugin_dir',dirname(__FILE__).'/../Plugins');
    $manager = new PluginManager();
    $results = $manager->setupPlugins();
    expect($results[0]['data'])->toEqual('Boot:ModuleAModuleB');
});
