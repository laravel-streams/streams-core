<?php namespace Anomaly\Streams\Platform\Provider;

use Anomaly\Streams\Platform\Asset\Asset;
use Anomaly\Streams\Platform\Asset\Image;
use Illuminate\Filesystem\Filesystem;

/**
 * Class AssetServiceProvider
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Provider
 */
class AssetServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Register the asset utility.
     */
    public function register()
    {
        $this->registerServiceProvider();

        $this->addAssetNamespaceHint();
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

        $this->app->singleton(
            'streams.image',
            function () {

                return new Image();
            }
        );
    }

    /**
     * Add the "asset" namespace to asset class.
     */
    protected function addAssetNamespaceHint()
    {
        app('streams.asset')->addNamespace('asset', public_path('assets/' . app('streams.application')->getReference()));
    }

    /**
     * Add the "streams" namespace hint to asset class.
     */
    protected function addStreamsNamespaceHint()
    {
        app('streams.asset')->addNamespace('streams', __DIR__ . '/../../../../../resources');
    }
}
