<?php

namespace Sunhill\Framework\Plugins\Traits;

use Sunhill\Framework\Plugins\Collections\PluginCollection;
use Sunhill\Framework\Plugins\Contracts\Plugin;

trait HasPlugins
{
    public function bootHasPlugins(): void
    {
        if (empty($this->plugins)) {
            $this->plugins = new PluginCollection();
        }
    }

    /**
     * @return PluginCollection<Plugin>
     */
    public function getPlugins(): PluginCollection
    {
        return $this->plugins;
    }

    /**
     * @param  PluginCollection<Plugin>  $plugins
     * @return self
     */
    public function setPlugins(PluginCollection $plugins): self
    {
        $this->plugins = $plugins;

        return $this;
    }

    /**
     * @param  PluginCollection<Plugin>  $plugins
     * @return self
     */
    public static function usePlugins(PluginCollection $plugins): self
    {
        return (new static())->setPlugins($plugins);
    }
}
