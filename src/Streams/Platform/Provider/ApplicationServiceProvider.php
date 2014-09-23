<?php namespace Streams\Platform\Provider;

use Illuminate\Support\ServiceProvider;
use Streams\Platform\Foundation\Application;
use Streams\Platform\Stream\Utility\StreamSchemaUtility;

class ApplicationServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->registerApplication();
        $this->registerSchemaUtility();

        $this->includeHelpers();

        $this->addNamespace();

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
     * Include package helper file.
     */
    protected function includeHelpers()
    {
        include __DIR__ . '/../../../../resources/helpers.php';
    }

    /**
     * Add streams namespaces.
     */
    protected function addNamespace()
    {
        \Config::set('view.paths', [__DIR__ . '/../../../../resources/views']);

        \View::addNamespace('streams', __DIR__ . '/../../../../resources/views');
    }
}
