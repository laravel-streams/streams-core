<?php namespace Anomaly\Streams\Platform\Addon\Plugin\Command\Handler;

use Anomaly\Streams\Platform\Addon\Plugin\PluginCollection;

/**
 * Class AddPluginsToTwigHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Plugin\Command
 */
class AddPluginsToTwigHandler
{

    /**
     * The plugin collection.
     *
     * @var PluginCollection
     */
    protected $plugins;

    /**
     * Create a new AddPluginsToTwigHandler instance.
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
