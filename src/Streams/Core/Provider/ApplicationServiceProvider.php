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

        $this->includeRoutes();

        \Application::locate();
    }

    /**
     * Register the application class.
     */
    protected function registerApplication()
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
    protected function registerSchemaUtility()
    {
        $this->app->singleton(
            'streams.schema.utility',
            function () {
                return new StreamSchemaUtility();
            }
        );
    }

    /**
     * Include package resource files.
     */
    protected function includeRoutes()
    {
        include __DIR__.'/../Http/routes.php';
    }
}
