<?php namespace Anomaly\Streams\Platform\Stream;

use Illuminate\Support\ServiceProvider;

/**
 * Class StreamServiceProvider
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Stream
 */
class StreamServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBindings();
        $this->registerListeners();
    }

    /**
     * Register stream management bindings.
     */
    protected function registerBindings()
    {
        $this->app->bind(
            'Anomaly\Streams\Platform\Stream\StreamModel',
            config('streams::config.streams.model')
        );

        $this->app->bind(
            '\Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface',
            config('streams::config.streams.repository')
        );
    }

    /**
     * Register the stream listener.
     */
    protected function registerListeners()
    {
        $this->app['events']->listen(
            'Anomaly.Streams.Platform.Stream.Event.*',
            'Anomaly\Streams\Platform\Stream\StreamListener'
        );
    }
}
