<?php namespace Anomaly\Streams\Platform\Support;

use Illuminate\Support\ServiceProvider;

/**
 * Class SupportServiceProvider
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Support
 */
class SupportServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            'Anomaly\Streams\Platform\Support\Configurator',
            'Anomaly\Streams\Platform\Support\Configurator'
        );

        $this->app->singleton(
            'Anomaly\Streams\Platform\Support\Evaluator',
            'Anomaly\Streams\Platform\Support\Evaluator'
        );

        $this->app->singleton(
            'Anomaly\Streams\Platform\Support\Parser',
            'Anomaly\Streams\Platform\Support\Parser'
        );

        $this->app->singleton(
            'Anomaly\Streams\Platform\Support\Resolver',
            'Anomaly\Streams\Platform\Support\Resolver'
        );
    }
}
