<?php

namespace Sunhill\Framework\Plugins;

use Sunhill\Framework\Plugins\Enums\PluginState;

class PluginManager
{
    /**
     * @return array<string, PluginState>
     */
    public function getPluginStates(): array
    {
        // @todo

        return [];
    }

    public function updatePluginState(Contracts\Plugin $plugin, PluginState $state): void
    {
        // @todo
    }

    /**
     * @return array<\Sunhill\Framework\Plugins\Contracts\Plugin>
     */
    public function availablePlugins(): array
    {
        // @todo

        return [];
    }
}
