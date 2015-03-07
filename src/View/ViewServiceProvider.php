<?php namespace Anomaly\Streams\Platform\View;

use Illuminate\Support\ServiceProvider;

/**
 * Class ViewServiceProvider
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\View
 */
class ViewServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->make('view')->addNamespace('streams', __DIR__ . '/../../resources/views');
        $this->app->make('view')->composer('*', 'Anomaly\Streams\Platform\View\ViewComposer');

        $this->app->singleton(
            'Anomaly\Streams\Platform\View\ViewTemplate ',
            'Anomaly\Streams\Platform\View\ViewTemplate'
        );

        $this->app->register('Anomaly\Streams\Platform\View\ViewEventProvider');
    }
}
