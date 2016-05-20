<?php namespace Anomaly\Streams\Platform\View\Cache;

use Asm89\Twig\CacheExtension\CacheProviderInterface;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Contracts\Cache\Store;

/**
 * Class CacheAdapter
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 * @package       Anomaly\Streams\Platform\View\Cache
 */
class CacheAdapter implements CacheProviderInterface
{

    /**
     * The cache repository.
     *
     * @var Repository
     */
    protected $cache;

    /**
     * Create a new cache adapter.
     *
     * @param Repository $cache
     */
    public function __construct(Repository $cache)
    {
        $this->cache = $cache;
    }

    /**
     * Get the cached value.
     *
     * @param string $key
     * @return mixed
     */
    public function fetch($key)
    {
        return $this->cache->get($key, false);
    }

    /**
     * Put the cached value.
     *
     * @param string $key
     * @param string $value
     * @param int    $lifetime
     */
    public function save($key, $value, $lifetime = 0)
    {
        $this->cache->put($key, $value, $lifetime);
    }
}
