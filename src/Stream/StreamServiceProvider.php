<?php namespace Anomaly\Streams\Platform\Stream;

use Anomaly\Streams\Platform\Stream\Command\ObserveStreamModel;
use Anomaly\Streams\Platform\Stream\Command\RegisterListeners;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Support\ServiceProvider;

/**
 * Class StreamServiceProvider
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Stream
 */
class StreamServiceProvider extends ServiceProvider
{

    use DispatchesCommands;

    /**
     * Boot the service provider.
     */
    public function boot()
    {
        $this->dispatch(new RegisterListeners());
        $this->dispatch(new ObserveStreamModel());
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'Anomaly\Streams\Platform\Stream\StreamModel',
            config('streams::config.streams.model')
        );
        $this->app->bind(
            'Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface',
            config('streams::config.streams.repository')
        );
    }
}
