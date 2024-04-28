<?php

namespace Sunhill\Framework\Tests\Unit\Crud;

use Sunhill\Framework\Tests\TestCase;
use Sunhill\Framework\Crud\AbstractCrudEngine;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use Sunhill\Framework\Crud\Exceptions\FieldNotSortableException;
use Sunhill\Framework\Crud\CrudListResponse;

uses(TestCase::class);

function getStdClass($items)
{
    $result = new \StdClass();
    foreach ($items as $key => $value) {
        $result->$key = $value;
    }
    return $result;
}

function getListResponse($entries = 30, $features = ['show','edit','delete','userfilters'], $offset = 0, $limit = 10, $order = null, $filter = null, $data = null, $filters = null)
{
    if (is_null($features)) {
        $features = ['show','edit','delete','userfilters'];
    }
    if (is_null($data)) {
        $data = [
            getStdClass(['id'=>1, 'item'=>'A','payload'=>3]),
            getStdClass(['id'=>2, 'item'=>'B','payload'=>5]),
            getStdClass(['id'=>3, 'item'=>'C','payload'=>9]),
            getStdClass(['id'=>4, 'item'=>'D','payload'=>3]),
            getStdClass(['id'=>5, 'item'=>'E','payload'=>4]),
            getStdClass(['id'=>6, 'item'=>'F','payload'=>8]),
            getStdClass(['id'=>7, 'item'=>'G','payload'=>1]),
            getStdClass(['id'=>8, 'item'=>'H','payload'=>2]),
            getStdClass(['id'=>9, 'item'=>'I','payload'=>6]),
            getStdClass(['id'=>10, 'item'=>'J','payload'=>7]),
        ];
    }
    App::setLocale('en');
    $engine = \Mockery::mock(AbstractCrudEngine::class);
    $engine->shouldReceive('getElementCount')->once()->andReturns($entries);
    $engine->shouldReceive('isSortable')->once()->with('id')->andReturn(true);
    $engine->shouldReceive('isSortable')->once()->with('item')->andReturns(true);
    $engine->shouldReceive('isSortable')->once()->with('payload')->andReturns(false);
    $engine->shouldReceive('getFilters')->once()->andReturns(is_null($filter)?['itemfilter'=>'Item filter','payloadfilter'=>'Payload filter']:$filter);
    $engine->shouldReceive('getListEntries')->once()->with($offset, $limit, $order, $filter)->andReturns($data);
    $engine->shouldReceive('getColumns')->once()->andReturn(['id'=>'id','item'=>'value','payload'=>'value']);
    $engine->shouldReceive('getColumnTitle')->once()->with('id')->andReturn('id');
    $engine->shouldReceive('getColumnTitle')->once()->with('item')->andReturn('item');
    $engine->shouldReceive('getColumnTitle')->once()->with('payload')->andReturn('payload');
    Route::get('/test/list/{offset?}/{limit?}/{order?}/{filter?}', function() { return 'list'; })->name('test.list');
    Route::get('/test/show/{id}', function($id) { return 'show '.$id; })->name('test.show');
    Route::get('/test/edit/{id}', function($id) { return 'edit '.$id; })->name('test.edit');
    Route::get('/test/delete/{id}', function($id) { return 'delete '.$id; })->name('test.delete');
    Route::get('/admin', function() { return 'admin'; })->name('admin.settings');
    $test = new CrudListResponse($engine);
    $test->setParameters([ // This is required because we call it directly
        'sitename'=>'testsite',
        'hamburger_entries'=>[],
    ]);
    $test->setOffset($offset);
    $test->setLimit($limit);
    if (!is_null($order)) {
        $test->setOrder($order);
    }
    if (!is_null($filter)) {
        $test->setFilter($filter);
    }
    $test->setRouteBase('test');
    foreach ($features as $feature) {
        $method = 'enable'.ucfirst($feature);
        $test->$method();
    }
    return $test->getResponse()->render();    
}

// ''''''''''''''''''''''''' Data table '''''''''''''''''''''''''''''''''''''''''''
test('CRUD list displays entries', function()
{
    expect(getListResponse())->toContain('<td class="id">2</td>');
    expect(getListResponse())->toContain('<td class="value">B</td>');
    expect(getListResponse())->toContain('<td class="value">3</td>');
});

test('CRUD list displays show link', function()
{
    expect(getListResponse())->toContain('<a class="show" href="'.route('test.show',['id'=>1]).'">show</a>');
});

test('CRUD list displays edit link', function()
{
    expect(getListResponse())->toContain('<a class="edit" href="'.route('test.edit',['id'=>1]).'">edit</a>');
});

test('CRUD list displays delete link', function()
{
    expect(getListResponse())->toContain('<a class="delete" href="'.route('test.delete',['id'=>1]).'">delete</a>');
});

test('CRUD doesnt display links when features disbaled', function()
{
    $response = getListResponse(30,[]);
    expect($response)->not->toContain('<a class="show" href="'.route('test.show',['id'=>1]).'">show</a>');
    expect($response)->not->toContain('<a class="edit" href="'.route('test.edit',['id'=>1]).'">edit</a>');
    expect($response)->not->toContain('<a class="delete" href="'.route('test.delete',['id'=>1]).'">delete</a>');
});

test('CRUD list handles empty data set', function() {
  $response = getListResponse(0,null,0,10,null,null,[]);
  expect($response)->toContain('No entries.');
});

// ***************************  Paginator *****************************************
test('CRUD list displays right paginator links when first', function()
{
    $response = getListResponse();
    expect($response)->toContain('<a href="'.route('test.list',['offset'=>10]).'">2</a>');    
    expect($response)->toContain('<a href="'.route('test.list',['offset'=>10]).'">next</a>');
    expect($response)->not->toContain('prev</a>');
});

test('CRUD list displays right paginator links when last', function()
{
    $response = getListResponse(30,null,20);
    expect($response)->not->toContain('next</a>');
    expect($response)->toContain('<a href="'.route('test.list',['offset'=>10]).'">prev</a>');
});

test('CRUD list displays right paginator links when middle', function()
{
    $response = getListResponse(30,null,10);
    expect($response)->toContain('<a href="'.route('test.list',['offset'=>20]).'">next</a>');
    expect($response)->toContain('<a href="'.route('test.list',['offset'=>0]).'">prev</a>');
});

test('CRUD list displays right paginator count', function()
{
    $response = getListResponse();
    expect($response)->toContain('<div class="paginator">');
    expect($response)->not->toContain('<a href="'.route('test.list',['offset'=>0]).'">1</a');
    expect($response)->toContain('<div class="active-page">1</div>');
    expect($response)->toContain('<a href="'.route('test.list',['offset'=>10]).'">1</a');
    expect($response)->toContain('<a href="'.route('test.list',['offset'=>20]).'">1</a');
    expect($response)->not->toContain('<a href="'.route('test.list',['offset'=>30]).'">1</a');
});

test('CRUD list displays no paginator when too few entries', function()
{
    $response = getListResponse(5);
    expect($response)->not->toContain('<div class="paginator">');
});

test('CRUD list displays paginator for one additional entry', function()
{
    $response = getListResponse(31);
    expect($response)->toContain(route('test.list',['offset'=>30]));
});

test('CRUD list displays paginator with ellipse with offset 0', function() 
{
   $response = getListResponse(1000,null,0);
   expect($response)->not->toConatin(route('test.list',['offset'=>0]));
   expect($response)->toConatin(route('test.list',['offset'=>100]));
   expect($response)->not->toConatin(route('test.list',['offset'=>110]));
   expect($response)->toContain('<div class="ellipse">...</div>');
   expect($response)->toConatin(route('test.list',['offset'=>990]));
});

test('CRUD list displays paginator with ellipse with offset 50', function()
{
    $response = getListResponse(1000,null,50);
    expect($response)->toConatin(route('test.list',['offset'=>0]));
    expect($response)->toConatin(route('test.list',['offset'=>100]));
    expect($response)->not->toConatin(route('test.list',['offset'=>110]));
    expect($response)->toContain('<div class="ellipse">...</div>');
    expect($response)->toConatin(route('test.list',['offset'=>990]));
});

test('CRUD list displays paginator with ellipse with offset 500', function()
{
    $response = getListResponse(1000,null,50);
    expect($response)->toConatin(route('test.list',['offset'=>0]));
    expect($response)->not->toConatin(route('test.list',['offset'=>440]));
    expect($response)->toConatin(route('test.list',['offset'=>450]));
    expect($response)->toConatin(route('test.list',['offset'=>550]));
    expect($response)->toContain('<div class="ellipse">...</div>');
    expect($response)->not->toConatin(route('test.list',['offset'=>560]));
    expect($response)->toConatin(route('test.list',['offset'=>990]));
});

// ============================ sorting ================================
test('CRUD list displays order columns', function()
{
    $response = getListResponse();
    expect($response)->toContain('<td><a class="active_asc" href="'.route('test.list',['offset'=>0,'limit'=>10,'order'=>'!id']).'>id</a></td>');
    expect($response)->toContain('<td><a href="'.route('test.list',['offset'=>0,'limit'=>10,'order'=>'item']).'>item</a></td>');
    expect($response)->toContain('<td>payload</td>');
});

test('CRUD list displays order columns with offset', function()
{
    $response = getListResponse(30,null,20);
    expect($response)->toContain('<td><a class="active_asc" href="'.route('test.list',['offset'=>0,'limit'=>10,'order'=>'!id']).'>id</a></td>');
    expect($response)->toContain('<td><a href="'.route('test.list',['offset'=>0,'limit'=>10,'order'=>'item']).'>item</a></td>');
    expect($response)->toContain('<td>payload</td>');
});

test('CRUD list respects ordering asc and marks column', function()
{
   $response = getListResponse(10, null, 0, 10, 'item');
   expect($response)->toContain('<a class="active_asc" href="'.route('test.list',['offset'=>0,'limit'=>10,'order'=>'!item']).">item</a>");
});

test('CRUD list respects ordering desc and marks column', function()
{
    $response = getListResponse(10, null, 0, 10, '!item');
    expect($response)->toContain('<a class="active_desc" href="'.route('test.list',['offset'=>0,'limit'=>10,'order'=>'item']).">item</a>");
});

test('CRUD list fails when sort field is not sortable', function()
{
    getListResponse(10, null, 0, 10, 'payload');    
})->throws(FieldNotSortableException::class);

// ============================ filter =================================
test('CRUD list offsers filters', function()
{
    $response = getListResponse();
    expect($response)->toContain('<select class="filter">')->toContain('<option value="none">(no filter)>option>');
});