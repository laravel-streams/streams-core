<?php namespace Anomaly\Streams\Platform\Stream;

use Illuminate\Support\ServiceProvider;

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

    protected function registerListeners()
    {
        $this->app['events']->listen(
            'Anomaly.Streams.Platform.Stream.Event.*',
            'Anomaly\Streams\Platform\Stream\StreamListener'
        );
    }
}
