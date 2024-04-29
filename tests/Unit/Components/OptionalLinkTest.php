<?php

use Sunhill\Framework\Tests\TestCase;

uses(TestCase::class);

test('entry with link is rendered', function()
{
    expect(view('framework::components.optional_link',['entry'=>makeStdClass(['link'=>'http://example.com','title'=>'example'])])->render())
    ->toContain('<div class="optional-link"><a href="http://example.com">example</a></div>');
});

test('entry without link is rendered', function()
{
    expect(view('framework::components.optional_link',['entry'=>makeStdClass(['title'=>'example'])])->render())
    ->toContain('<div class="optional-link">example</div>');    
});


test('template with optional-link tag is rendered', function()
{
    expect(view('framework::test.optionallink', [
        'link'=>makeStdClass(['link'=>'http://example.com','title'=>'example']), 
        'sitename'=>'test'
    ])->render())->toContain('<div class="optional-link"><a href="http://example.com">example</a></div>');
});

test('template without optional-link tag is rendered', function()
{
    expect(view('framework::test.optionallink',[
        'link'=>makeStdClass(['title'=>'example']),
        'sitename'=>'test'
        
    ])->render())->toContain('<div class="optional-link">example</div>');
    
});