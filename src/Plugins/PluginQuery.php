<?php

namespace Sunhill\Framework\Plugins;

use Sunhill\Basic\Query\ArrayQuery;
use IsaEken\PluginSystem\Enums\PluginState;

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
    
    public function getKey($entry, $key)
    {
        switch ($key) {
            case 'name':
                return $entry->getName();
            case 'author':
                return $entry->getAuthor();
            case 'version':
                return $entry->getVersion();
            case 'state':
                switch ($entry->getState()) {
                    case PluginState::Enabled:
                        return 'enabled';
                    case PluginState::Disabled:
                        return 'disabled';
                    case PluginState::Outdated:
                        return 'outdated';
                }
        }
    }
}