<?php namespace Anomaly\Streams\Platform\Asset;

use Anomaly\Streams\Platform\Asset\Command\AddAssetNamespaces;
use Illuminate\Foundation\Bus\DispatchesCommands;
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

    use DispatchesCommands;

    /**
     * Boot the service provider.
     */
    public function boot()
    {
        $this->dispatch(new AddAssetNamespaces());

        $this->app->make('twig')->addExtension($this->app->make('Anomaly\Streams\Platform\Asset\AssetPlugin'));
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            'Anomaly\Streams\Platform\Asset\Asset',
            'Anomaly\Streams\Platform\Asset\Asset'
        );

        $this->app->instance('streams.path', $this->app->make('path.base') . '/vendor/anomaly/streams-platform');
    }
}
