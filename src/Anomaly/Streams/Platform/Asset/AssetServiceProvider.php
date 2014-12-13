<?php namespace Anomaly\Streams\Platform\Asset;

use Illuminate\Support\ServiceProvider;

class AssetServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('streams.asset', 'Anomaly\Streams\Platform\Asset\Asset');

        $this->app['streams.asset.path'] = public_path('assets/' . $this->app['streams.application']->getReference());
    }
}
