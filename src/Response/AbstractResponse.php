<?php

namespace Sunhill\Framework\Response;

abstract class AbstractResponse
{
    
    protected $parameters;
    
    public function setParameters(array $parameters): self
    {
        $this->parameters = $parameters;
        return $this;
    }
    
    protected function getParameters(): array
    {
        return $this->parameters;    
    }
    
    public function getResponse()
    {
        if ($response = $this->prepareResponse()) {
            return $response;
        }
        return $this->getErrorResponse();    
    }
    
    abstract protected function prepareResponse();
    
    protected function getErrorResponse()
    {
        
    }
}