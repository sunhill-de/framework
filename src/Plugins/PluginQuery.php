<?php

namespace Sunhill\Framework\Plugins;

use Sunhill\Basic\Query\ArrayQuery;

class PluginQuery extends ArrayQuery
{
    protected $plugins = [];
    
    protected $allowed_order_keys = ['none','name','author','version','state'];
    
    public function __construct(array $plugins)
    {
        parent::__construct();
        $this->plugins = $plugins;
    }
    
    protected function getRawData()
    {
        return $this->plugins;
    }
}