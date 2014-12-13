<?php namespace Anomaly\Streams\Platform\Application;

use Laracasts\Commander\Events\EventListener;

class ApplicationListener extends EventListener
{
    public function whenApplicationIsBooting()
    {
        app('translator')->addNamespace('streams', app('streams.path') . '/resources/lang');
        app('translator')->addNamespace(null, base_path('resources/lang'));

        app('view')->composer('*', 'Anomaly\Streams\Platform\View\Composer');
    }
}
