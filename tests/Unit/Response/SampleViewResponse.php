<?php

namespace Sunhhil\Framework\Tests\Unit\Response;

use Sunhill\Framework\Response\ViewResponses\ViewResponse;

class SampleViewResponse extends ViewResponse
{
    
    protected function getViewElements(): array
    {
        return ['test'=>'ABC'];    
    }
    
    public function setTemplate(string $template)
    {
        $this->template = $template;
    }
}