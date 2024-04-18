<?php

use Sunhill\Framework\Response\AssembleResponse;

uses(\Sunhill\Framework\Tests\TestCase::class);

test('Response assembles two files', function() {
    $test = new AssembleResponse();
    $test->addFile('fileA');
    $test->addFile('fileB');
});