<?php namespace Streams\Core\Provider;

use Streams\Core\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Streams\Core\Stream\Utility\StreamSchemaUtility;

class ApplicationServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->registerApplication();
        $this->registerSchemaUtility();

        \Application::locate();
    }

    /**
     * Register the application class.
     */
    public function registerApplication()
    {
        $this->app->singleton(
            'streams.application',
            function () {
                return new Application($this->app);
            }
        );
    }

    /**
     * Register the SchemaUtility.
     */
    public function registerSchemaUtility()
    {
        $this->app->singleton(
            'streams.schema.utility',
            function () {
                return new StreamSchemaUtility();
            }
        );
    }
}
