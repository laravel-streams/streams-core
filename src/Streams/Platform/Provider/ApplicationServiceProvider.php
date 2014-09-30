<?php namespace Streams\Platform\Provider;

use Illuminate\Support\ServiceProvider;
use Streams\Platform\Foundation\Application;
use Streams\Platform\Foundation\Model\ApplicationModel;
use Streams\Platform\Stream\Utility\StreamSchemaUtility;

class ApplicationServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->registerApplication();

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
}
