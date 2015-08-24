<?php namespace Anomaly\Streams\Platform;

use Anomaly\Streams\Platform\Addon\Plugin\Plugin;

/**
 * Class StreamsPlugin
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform
 */
class StreamsPlugin extends Plugin
{

    /**
     * The plugin functions.
     *
     * @var StreamsPluginFunctions
     */
    protected $functions;

    /**
     * Create a new StreamsPlugin instance.
     *
     * @param StreamsPluginFunctions $functions
     */
    public function __construct(StreamsPluginFunctions $functions)
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
            new \Twig_SimpleFunction('streams_form', [$this->functions, 'form'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('streams_paginated', [$this->functions, 'paginated']),
            new \Twig_SimpleFunction('streams_entries', [$this->functions, 'entries']),
            new \Twig_SimpleFunction('streams_entry', [$this->functions, 'entry'])
        ];
    }
}
