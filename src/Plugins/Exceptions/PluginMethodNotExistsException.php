<?php

namespace Sunhill\Framework\Plugins\Exceptions;

use Sunhill\Framework\Plugins\Contracts\Plugin;

class PluginMethodNotExistsException extends \Exception
{
    public function __construct(Plugin $plugin, string $method)
    {
        parent::__construct("Plugin method \"{$method}\" not exists in \"{$plugin->getName()}\"");
    }
}
