<?php namespace Anomaly\Streams\Platform\Addon\Plugin\Command;

use Anomaly\Streams\Platform\Addon\Plugin\PluginCollection;

/**
 * Class AddPluginsToTwigCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Plugin\Command
 */
class AddPluginsToTwigCommandHandler
{

    /**
     * The plugin collection.
     *
     * @var PluginCollection
     */
    protected $plugins;

    /**
     * Create a new AddPluginsToTwigCommandHandler instance.
     *
     * @param PluginCollection $plugins
     */
    public function __construct(PluginCollection $plugins)
    {
        $this->plugins = $plugins;
    }

    /**
     * Handle the command.
     */
    public function handle()
    {
        foreach ($this->plugins as $plugin) {
            app('twig')->addExtension($plugin);
        }
    }
}
