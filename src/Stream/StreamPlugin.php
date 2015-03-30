<?php namespace Anomaly\Streams\Platform\Stream;

use Anomaly\Streams\Platform\Addon\Plugin\Plugin;

/**
 * Class StreamPlugin
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Stream
 */
class StreamPlugin extends Plugin
{

    /**
     * The plugin functions.
     *
     * @var StreamPluginFunctions
     */
    protected $functions;

    /**
     * Create a new StreamPlugin instance.
     *
     * @param StreamPluginFunctions $functions
     */
    public function __construct(StreamPluginFunctions $functions)
    {
        $this->functions = $functions;
    }

    /**
     * Get the plugin functions.
     *
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('streams_entries', [$this->functions, 'entries'])
        ];
    }
}
