<?php namespace Anomaly\Streams\Platform\Exception;

use Illuminate\Support\ServiceProvider;

/**
 * Class ExceptionServiceProvider
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Exception
 */
class ExceptionServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'Illuminate\Contracts\Debug\ExceptionHandler',
            'Anomaly\Streams\Platform\Exception\ExceptionHandler'
        );
    }
}
