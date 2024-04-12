<?php

use Sunhill\Framework\Response\Exceptions\MissingTemplateException;
use Sunhhil\Framework\Tests\Responses\SampleViewResponse;
use Sunhill\Framework\Tests\TestCase;
use Sunhill\Framework\Modules\AbstractModule;
use Illuminate\Support\Facades\Route;

uses(\Sunhill\Framework\Tests\TestCase::class);

it('throws exception when no template is set', function() {
    $test = new SampleViewResponse();
    $test->getResponse();
})->throws(MissingTemplateException::class);

test('Sample parsing works', function() {
    $test = new SampleViewResponse();
    $test->setTemplate('framework::test.viewresponse');
    $test->setParameters(['sitename'=>'test']);
    expect($test->getResponse()->render())->toContain('TEST:abc');
});

test('Routing works with', function($hirachy, $arguments, $url, $expect_url, $aliasoverwrite, $alias) 
{
    $module = Mockery::mock(AbstractModule::class);
    $module->shouldReceive('getHirachy')->once()->andReturn($hirachy);
    $module->shouldReceive('getPath')->once()->andReturn($url);
    $test = new SampleViewResponse();
    $test->setName('action');
    $test->setOwner($module);
    $test->addRoute($aliasoverwrite);
    $routes = Route::getRoutes();
    expect($routes->routes['GET'])->toBe(true);    
    expect(Route::has($alias))->toBe(true);
})->with(
[
    'simple route, no args, no alias'=>[['first'=>'dummy','second'=>'dummy'],'','/first/second/','/first/second/action','','first.second.action'],   
]);