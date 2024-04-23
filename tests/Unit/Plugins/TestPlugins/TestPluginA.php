<?php

namespace Sunhill\Framework\Tests\Unit\Plugins\TestPlugins;

use Sunhill\Framework\Plugins\Plugin;
use IsaEken\PluginSystem\Enums\PluginState;

class TestPluginA extends Plugin
{
    
    protected string $name = 'TestPluginA';
    
    protected string|array $author = 'Some Author';
    
    protected string $version = '0.0.1';
    
    protected PluginState $state = PluginState::Enabled;
    
    protected $provides = ['marketeer'];
    
    public $installers = [];
}