<?php namespace Streams\Platform\Provider;

use Illuminate\Support\ServiceProvider;

class ResourcesServiceProvider extends ServiceProvider
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

        app()->make('streams.application')->locate();
    }

    /**
     * Register the application class.
     */
    protected function registerApplication()
    {
        $this->app->singleton(
            'streams.application',
            function () {
                return new Application(new ApplicationModel(), $this->app);
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

        \Asset::addNamespace('streams', __DIR__ . '/../../../../resources');

        \View::addNamespace('streams', __DIR__ . '/../../../../resources/views');
    }
}
