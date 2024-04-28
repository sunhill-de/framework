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