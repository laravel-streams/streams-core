<?php namespace Anomaly\Streams\Platform\Asset;

use Illuminate\Support\ServiceProvider;

/**
 * Class AssetServiceProvider
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Asset
 */
class AssetServiceProvider extends ServiceProvider
{

    /**
     * Boot the service provider.
     */
    public function boot()
    {
        $this->app->make('twig')->addExtension(app('Anomaly\Streams\Platform\Asset\AssetPlugin'));
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerAsset();
        $this->registerAssetPath();
        $this->addNamespaces();
    }

    /**
     * Register the asset class.
     */
    protected function registerAsset()
    {
        $this->app->singleton('Anomaly\Streams\Platform\Asset\Asset', 'Anomaly\Streams\Platform\Asset\Asset');
    }

    /**
     * Register the asset path.
     */
    protected function registerAssetPath()
    {
        $path = public_path('assets/' . $this->app->make('streams.application')->getReference());

        $this->app->instance('streams.asset.path', $path);
    }

    /**
     * Register a couple initial asset paths.
     */
    protected function addNamespaces()
    {
        $this->app->make('Anomaly\Streams\Platform\Asset\Asset')->addNamespace(
            'asset',
            public_path('assets/' . app('streams.application')->getReference())
        );

        $this->app->make('Anomaly\Streams\Platform\Asset\Asset')->addNamespace(
            'streams',
            $this->app->make('streams.path') . '/resources'
        );
    }
}
