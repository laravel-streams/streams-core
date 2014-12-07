<?php namespace Anomaly\Streams\Platform\Provider;

use Anomaly\Streams\Platform\Collection\CacheCollection;

/**
 * Class CacheServiceProvider
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Provider
 */
class CacheServiceProvider extends \Illuminate\Support\ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerCacheCollection();
    }

    /**
     * Register the cache collection.
     */
    protected function registerCacheCollection()
    {
        $this->app->singleton(
            'streams.cache.collection',
            function () {

                return new CacheCollection();
            }
        );
    }
}
 