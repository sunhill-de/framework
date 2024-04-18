<?php

namespace Sunhill\Framework\Response;

use Sunhill\Framework\Response\AbstractResponse;

abstract class AssembleResponse extends AbstractResponse
{

    protected $files_or_dirs = [];
    
    protected function prepareResponse()
    {    
    }
    
}