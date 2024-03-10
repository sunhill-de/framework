<?php

namespace Sunhill\Framework\Plugins\Enums;

enum PluginState: string
{
    case Enabled = 'enabled';
    case Disabled = 'disabled';
    case Outdated = 'outdated';
}
