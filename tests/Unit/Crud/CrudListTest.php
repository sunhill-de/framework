<?php

namespace Sunhill\Framework\Tests\Unit\Crud;

use Sunhill\Framework\Tests\TestCase;
use Sunhill\Framework\Crud\AbstractCrudEngine;

uses(TestCase::class);

function getStdClass($items)
{
    $result = new \StdClass();
    foreach ($items as $key => $value) {
        $result->$key = $value;
    }
    return $result;
}

test('CRUD list displays entries', function()
{
   $engine = \Mockery::mock(AbstractCrudEngine::class);
   $engine->shouldReceive('getListEntries')->once()->with(0,10)->andReturn(
       [
           getStdClass(['id'=>1, 'item'=>'A']),
           getStdClass(['id'=>2, 'item'=>'B']),
           getStdClass(['id'=>3, 'item'=>'C']),
           getStdClass(['id'=>4, 'item'=>'D']),
           getStdClass(['id'=>5, 'item'=>'E']),
           getStdClass(['id'=>6, 'item'=>'F']),
           getStdClass(['id'=>7, 'item'=>'G']),
           getStdClass(['id'=>8, 'item'=>'H']),
           getStdClass(['id'=>9, 'item'=>'I']),
           getStdClass(['id'=>10, 'item'=>'J']),
       );
   
   $test = new CrudListResponse($engine);
   expect($test->getResponse()->render())->toContain('B');
});