<?php namespace Anomaly\Streams\Platform\Message;

use Illuminate\Support\ServiceProvider;

/**
 * Class MessageServiceProvider
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\MessageBag
 */
class MessageServiceProvider extends ServiceProvider
{

    /**
     * Boot the service provider.
     */
    public function boot()
    {
        $this->app->make('twig')->addExtension($this->app->make('Anomaly\Streams\Platform\Message\MessagePlugin'));
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            'Anomaly\Streams\Platform\Message\MessageBag',
            'Anomaly\Streams\Platform\Message\MessageBag'
        );
    }
}
