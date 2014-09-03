<?php namespace Streams\Core\Provider;

use Illuminate\Support\ServiceProvider;
use Streams\Core\Asset\Asset;

class AssetServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->singleton(
            'streams.asset',
            function () {
                return new Asset();
            }
        );
    }
}
