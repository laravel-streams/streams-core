<?php

namespace Anomaly\Streams\Platform\Addon\Plugin\Event;

use Anomaly\Streams\Platform\Addon\Plugin\Plugin;

/**
 * Class PluginWasRegistered.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Plugin\Event
 */
class PluginWasRegistered
{
    /**
     * The plugin object.
     *
     * @var Plugin
     */
    protected $plugin;

    /**
     * Create a new PluginWasRegistered instance.
     *
     * @param Plugin $plugin
     */
    public function __construct(Plugin $plugin)
    {
        $this->plugin = $plugin;
    }

    /**
     * Get the plugin object.
     *
     * @return Plugin
     */
    public function getPlugin()
    {
        return $this->plugin;
    }
}
