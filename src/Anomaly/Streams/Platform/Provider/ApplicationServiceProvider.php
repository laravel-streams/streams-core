<?php namespace Anomaly\Streams\Platform\Provider;

class ApplicationServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Register and setup the application.
     */
    public function register()
    {
        $this->app->instance('streams.application', app('Anomaly\Streams\Platform\Application\Application'));

        app('config')->addNamespace('streams', __DIR__ . '/../../../../resources/config');

        if (file_exists(base_path('config/distribution.php'))) {

            app('streams.application')->locate();

            if (file_exists(base_path('config/database.php'))) {

                app('streams.application')->setup();
            }
        }
    }
}
