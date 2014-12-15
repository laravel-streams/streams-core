<?php namespace Anomaly\Streams\Platform\Application\Listener;

/**
 * Class ApplicationBootingListener
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Application\Listener
 */
class ApplicationBootingListener
{

    /**
     * When the application is booting setup the
     * applications various service namespaces.
     */
    public function handle()
    {
        app('translator')->addNamespace('streams', app('streams.path') . '/resources/lang');
        app('translator')->addNamespace(null, base_path('resources/lang'));

        app('view')->composer('*', 'Anomaly\Streams\Platform\View\Composer');
    }
}
