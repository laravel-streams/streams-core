<?php namespace Anomaly\Streams\Platform\Http;

use Illuminate\Contracts\Http\Kernel;
use Symfony\Component\HttpKernel\HttpCache\SurrogateInterface;

/**
 * Class CacheKernel
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class CacheKernel extends \Barryvdh\HttpCache\CacheKernel
{

    /**
     * Wrap a Laravel Kernel in a Symfony HttpKernel
     *
     * @param Kernel $kernel
     * @param null $storagePath
     * @param SurrogateInterface|null $surrogate
     * @param array $options
     * @return Kernel|HttpCache
     */
    public static function wrap(
        Kernel $kernel,
        $storagePath = null,
        SurrogateInterface $surrogate = null,
        $options = []
    ) {

        /**
         * Start setting up the HttpCache kernel.
         */
        $storagePath = $storagePath ?: storage_path('httpcache');

        $store = new Store($storagePath);

        $wrapper = new static($kernel);

        $cache = new HttpCache($wrapper, $store, $surrogate, $options);

        app()->singleton(
            \Anomaly\Streams\Platform\Http\HttpCache::class,
            function () use ($cache) {
                return $cache;
            }
        );

        return $cache;
    }

}
