<?php namespace Streams\Platform\Provider;

use Streams\Platform\Asset\Asset;
use Illuminate\Support\ServiceProvider;

class AssetServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->registerServiceProvider();
        $this->addStreamsNamespaceHint();
    }

    /**
     * Register the asset class for Streams.
     */
    protected function registerServiceProvider()
    {
        $this->app->singleton(
            'streams.asset',
            function () {
                return new Asset();
            }
        );
    }

    /**
     * Add the "streams" namespace hint to asset.
     */
    protected function addStreamsNamespaceHint()
    {
        app('streams.asset')->addNamespace('streams', __DIR__ . '/../../../../resources');
    }
}
