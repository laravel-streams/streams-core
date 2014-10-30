<?php namespace Anomaly\Streams\Platform\Traits;

use Anomaly\Streams\Platform\Collection\CacheCollection;

trait CacheableTrait
{

    /**
     * Get a cache collection of keys or set the keys to be indexed.
     *
     * @param  string $collectionKey
     * @param  array  $keys
     * @return object
     */
    public function cacheCollection($collectionKey, $keys = [])
    {
        if (is_string($keys)) {
            $keys = [$keys];
        }

        if ($cached = \Cache::get($collectionKey) and is_array($cached)) {
            $keys = array_merge($keys, $cached);
        }

        $collection = CacheCollection::make($keys);

        return $collection->setKey($collectionKey);
    }

    /**
     * Flush a cache collection.
     *
     * @return \Streams\Model\EloquentModel
     */
    public function flushCacheCollection()
    {
        $this->cacheCollection($this->getCacheCollectionKey())->flush();

        return $this;
    }

    /**
     * Get a cache collection key.
     *
     * @return string
     */
    public function getCacheCollectionKey($suffix = null)
    {
        return $this->getCacheCollectionPrefix() . $suffix;
    }

    /**
     * Get a cache collection prefix.
     *
     * @return string
     */
    public function getCacheCollectionPrefix()
    {
        return get_called_class();
    }

    /**
     * Set the minutes in which to cache.
     *
     * @return integer
     */
    public function setCacheMinutes($cacheMinutes)
    {
        $this->cacheMinutes = $cacheMinutes;

        return $this;
    }

    /**
     * Get the minutes in which to cache.
     *
     * @return integer
     */
    public function getCacheMinutes()
    {
        return $this->cacheMinutes;
    }
}
