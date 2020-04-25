<?php

namespace Anomaly\Streams\Platform\Provider\Concerns;

use Illuminate\Console\Scheduling\Schedule;
use Anomaly\Streams\Platform\Stream\StreamRegistry;

/**
 * Trait ProvidesStreams
 *
 * @link   http://pyrocms.com/
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
trait ProvidesStreams
{

    /**
     * The Streams to register.
     *
     * @var array
     */
    public $streams = [];

    /**
     * Register provided Streams.
     * @todo revisit
     */
    protected function registerStreams()
    {
        foreach ($this->streams as $stream => $abstract) {

            app(StreamRegistry::class)->register($stream, $abstract);

            app()->singleton($this->namespace() . '::' . $stream, function () use ($abstract) {
                return app($abstract)->stream();
            });
        }
    }
}
