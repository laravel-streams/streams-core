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
     * Exclude these paths.
     *
     * @var array
     */
    protected static $exclude = [
        '/admin',
        '/admin/login',
        '/admin/logout',
        '/logout',
        '/login',
    ];

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
         * Do not even use the CacheKernel if
         * any of the following criteria is met.
         */
        if (
            strtoupper($_SERVER['REQUEST_METHOD']) !== 'GET' ||
            in_array($_SERVER['REQUEST_URI'], self::$exclude) ||
            starts_with($_SERVER['REQUEST_URI'], '/admin/')
        ) {
            return $kernel;
        }

        /**
         * Start setting up the HttpCache kernel.
         */
        $storagePath = $storagePath ?: storage_path('httpcache');

        $store = new Store($storagePath);

        $wrapper = new static($kernel);

        $kernel = new HttpCache($wrapper, $store, $surrogate, $options);

        return $kernel;
    }

}
