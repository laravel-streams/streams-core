<?php namespace Anomaly\Streams\Platform\Provider;

use Anomaly\Streams\Platform\Asset\Asset;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;

class AssetServiceProvider extends ServiceProvider
{

    /**
     * Register the asset utility.
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
                return new Asset(new Filesystem(), app('streams.application'));
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
