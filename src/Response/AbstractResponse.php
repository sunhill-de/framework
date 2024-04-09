<?php
/**
 * @file AbstractResponse.php
 * Provides the basic class for all other responses
 * Lang en
 * Reviewstatus: 2024-04-08
 * Localization:
 * Documentation:
 * Tests:
 * Coverage: unknown
 * PSR-State: complete
 */

namespace Sunhill\Framework\Response;

/**
 * A response is a way the framework can respond to a request of any kind
 * 
 * @author klaus
 *
 */
abstract class AbstractResponse
{
    
    /**
     * Stores the default parameters from the framework
     * 
     * @var array
     */
    protected $parameters = [];
    
    /**
     * Sets the parameters for this response
     * 
     * @param array $parameters
     * @return self
     */
    public function setParameters(array $parameters): self
    {
        $this->parameters = $parameters;
        return $this;
    }
    
    /**
     * Gets the parameters for this response 
     * 
     * @return array
     */
    protected function getParameters(): array
    {
        return $this->parameters;    
    }
    
    /**
     * Returns the response
     * 
     * @return unknown
     */
    public function getResponse()
    {
        if ($response = $this->prepareResponse()) {
            return $response;
        }
        return $this->getErrorResponse();    
    }
    
    /**
     * Prepares the response. It either returns a response string of false if something went wrong
     */
    abstract protected function prepareResponse();
    
    protected function getErrorResponse()
    {
        
    }
}