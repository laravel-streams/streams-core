<?php namespace Anomaly\Streams\Platform\Addon\Plugin\Listener;

use Anomaly\Streams\Platform\Addon\Plugin\Event\PluginWasRegistered;
use Anomaly\Streams\Platform\Addon\Plugin\PluginCollection;

/**
 * Class PutPluginInCollection
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Plugin\Listener
 */
class PutPluginInCollection
{

    /**
     * The plugin collection.
     *
     * @var PluginCollection
     */
    protected $plugins;

    /**
     * Create a new PutPluginInCollection instance.
     *
     * @param PluginCollection $plugins
     */
    public function __construct(PluginCollection $plugins)
    {
        $this->plugins = $plugins;
    }

    /**
     * Handle the event.
     *
     * @param PluginWasRegistered $event
     */
    public function handle(PluginWasRegistered $event)
    {
        $plugin = $event->getPlugin();

        $this->plugins->put(get_class($plugin), $plugin);
    }
}
