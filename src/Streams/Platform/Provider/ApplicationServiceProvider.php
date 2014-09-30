<?php namespace Streams\Platform\Provider;

use Illuminate\Support\ServiceProvider;
use Streams\Platform\Foundation\Application;
use Streams\Platform\Foundation\Model\ApplicationModel;

class ApplicationServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->instance('streams.application', new Application(new ApplicationModel(), $this->app));
    }
}
