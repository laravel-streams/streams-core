<?php namespace Anomaly\Streams\Platform\Provider;

use Anomaly\Streams\Platform\Application\Application;
use Anomaly\Streams\Platform\Application\ApplicationModel;

class ApplicationServiceProvider extends \Illuminate\Support\ServiceProvider
{

    /**
     * Register and setup the application.
     */
    public function register()
    {
        $request = app('request');

        $this->app->instance('streams.application', new Application(new ApplicationModel(), $this->app));

        app('config')->addNamespace('streams', __DIR__ . '/../../../../resources/config');

        // ARTISAN.. Breaks if location occurs.
        if ($request->segment(1) !== 'installer' and !ends_with($request->root(), 'localhost')) {

            app('streams.application')->locate();
            app('streams.application')->setup();

            define('APP_REF', app('streams.application')->getReference());
        } else {

            define('APP_REF', 'default');
        }
    }
}
