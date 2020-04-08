<?php

namespace Anomaly\Streams\Platform\Addon\Workflow;

use Anomaly\Streams\Platform\Addon\AddonServiceProvider;
use Anomaly\Streams\Platform\Stream\StreamRegistry;
use Illuminate\Contracts\Container\Container;

/**
 * Class RegisterStreams
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class RegisterStreams
{

    /**
     * The streams registry.
     *
     * @var StreamRegistry
     */
    protected $registry;

    /**
     * Create a new RegisterStreams instance.
     *
     * @param StreamRegistry $registry
     */
    public function __construct(StreamRegistry $registry)
    {
        $this->registry = $registry;
    }

    /**
     * Handle registering the addon's Streams.
     *
     * @param AddonServiceProvider $provider
     * @param Container $app
     * @param string $namespace
     */
    public function handle(AddonServiceProvider $provider, Container $app, $namespace)
    {
        foreach ($provider->streams as $stream => $abstract) {

            $this->registry->register($stream, $abstract);

            $app->singleton($namespace . '::' . $stream, function ($app) use ($abstract) {
                return $app->make($abstract)->stream();
            });
        }
    }
}
