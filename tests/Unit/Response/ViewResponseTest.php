<?php

use Sunhill\Framework\Response\Exceptions\MissingTemplateException;
use Sunhhil\Framework\Tests\Unit\Response\SampleViewResponse;
use Sunhill\Framework\Tests\TestCase;

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