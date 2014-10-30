<?php namespace Anomaly\Streams\Platform\Provider;

use Anomaly\Streams\Platform\Foundation\Application;
use Anomaly\Streams\Platform\Foundation\ApplicationModel;
use Illuminate\Support\ServiceProvider;

class ApplicationServiceProvider extends ServiceProvider
{

    /**
     * Register and setup the application.
     */
    public function register()
    {
        $request = app('request');

        $this->app->instance('streams.application', new Application(new ApplicationModel(), $this->app));

        app('config')->addNamespace('streams', __DIR__ . '/../../../../resources/config');

        if ($request->segment(1) !== 'installer') {

            app('streams.application')->locate();
            app('streams.application')->setup();

            define('APP_REF', app('streams.application')->getReference());
        } else {

            define('APP_REF', 'default');
        }
    }
}
