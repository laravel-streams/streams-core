<?php namespace Anomaly\Streams\Platform\Http;

use Illuminate\Contracts\Http\Kernel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
     * System excluded.
     *
     * @var array
     */
    protected static $excluded = [
        '/admin',
        '/admin/*',
        '/streams/*-field_type/*',
        '/streams/*-extension/*',
        '/streams/*-module/*',
        '/entry/handle/*',
        'form/handle/*',
        '/locks/touch',
        '/locks/release',
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

        /**
         * Disable for Control Panel
         */
        if (str_is(self::$excluded, $_SERVER['REQUEST_URI'])) {
            return $kernel;
        }

        return $cache;
    }

    /**
     * Terminate the response.
     *
     * @param Request $request
     * @param Response $response
     */
    public function terminate(Request $request, Response $response)
    {
        $this->kernel->terminate($request, $response);
    }

}
