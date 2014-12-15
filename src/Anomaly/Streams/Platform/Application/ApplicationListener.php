<?php namespace Anomaly\Streams\Platform\Application;

use Laracasts\Commander\Events\EventListener;

/**
 * Class ApplicationListener
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Application
 */
class ApplicationListener extends EventListener
{

    /**
     * Fired when the ApplicationServiceProvider starts booting.
     */
    public function whenApplicationIsBooting()
    {
        app('translator')->addNamespace('streams', app('streams.path') . '/resources/lang');
        app('translator')->addNamespace(null, base_path('resources/lang'));

        app('view')->composer('*', 'Anomaly\Streams\Platform\View\Composer');
    }
}
