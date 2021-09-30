<?php

namespace Streams\Core\Stream;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

/**
 * @property \Streams\Core\Field\FieldCollection|\Streams\Core\Field\Field[] fields
 *
 */
class StreamCache
{
    /**
     * Create a new instance.
     *
     * @param Stream $stream
     */
    public function __construct(Stream $stream)
    {
        $this->stream = $stream;

        $this->collections = Cache::store($stream->config('cache.collection', Config::get('cache.default')));

        $this->store = Cache::store($stream->config('cache.store', Config::get('cache.default')));
    }

    /**
     * Return a cached value.
     *
     * @param string $key
     * @param mixed
     * 
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return $this->store->get('streams.' . $this->stream->handle . '.' . $key, $default);
    }

    /**
     * Return if a cached item exists.
     *
     * @param string $key
     *
     * @return bool
     */
    public function has($key): bool
    {
        return $this->store->has('streams.' . $this->stream->handle . '.' . $key);
    }

    /**
     * Adjust the value of an integer item.
     *
     * @param string $key
     * @param int $amount
     *
     * @return int
     */
    public function increment($key, $amount = 1): int
    {
        $this->indexKey($key);

        return $this->store->increment('streams.' . $this->stream->handle . '.' . $key, $amount);
    }

    /**
     * Adjust the value of an integer item.
     *
     * @param string $key
     * @param int $amount
     *
     * @return int
     */
    public function decrement($key, $amount = 1): int
    {
        $this->indexKey($key);

        return $this->store->decrement('streams.' . $this->stream->handle . '.' . $key, $amount);
    }

    /**
     * Store a value in the cache store.
     *
     * @param string $key
     * @param integer $seconds
     * @param mixed $value
     * 
     * @return mixed
     */
    public function remember($key, $seconds, $value)
    {
        $key = 'streams.' . $this->stream->handle . '.' . $key;

        $this->indexKey($key);

        return $this->store->remember($key, $seconds, $value);
    }

    /**
     * Store a value in the cache store forever.
     *
     * @param string $key
     * @param mixed $value
     * 
     * @return mixed
     */
    public function rememberForever($key, $value)
    {
        $key = 'streams.' . $this->stream->handle . '.' . $key;

        $this->indexKey($key);

        return $this->store->rememberForever($key, $value);
    }

    /**
     * Put a value in to cache store.
     *
     * @param string $key
     * @param integer $seconds
     * @param mixed $value
     * 
     * @return bool
     */
    public function put($key, $value, $seconds = null): bool
    {
        $key = 'streams.' . $this->stream->handle . '.' . $key;

        $this->indexKey($key);

        return $this->store->put($key, $value, $seconds);
    }

    /**
     * Add a value in to cache
     * store if it doesn't exist.
     *
     * @param string $key
     * @param integer $seconds
     * @param mixed $value
     * 
     * @return bool
     */
    public function add($key, $value, $seconds): bool
    {
        $key = 'streams.' . $this->stream->handle . '.' . $key;

        if (!$this->has($key)) {
            $this->indexKey($key);
        }

        return $this->store->add($key, $value, $seconds);
    }

    /**
     * Store a value in cache forever.
     *
     * @param string $key
     * @param mixed $value
     * 
     * @return bool
     */
    public function forever($key, $value): bool
    {
        $key = 'streams.' . $this->stream->handle . '.' . $key;

        if (!$this->has($key)) {
            $this->indexKey($key);
        }

        return $this->store->forever($key, $value);
    }

    /**
     * Pull a value out of the cache store.
     *
     * @param string $key
     * 
     * @return mixed
     */
    public function pull($key)
    {
        $key = 'streams.' . $this->stream->handle . '.' . $key;

        $this->forgetKey($key);

        return $this->store->pull($key);
    }

    /**
     * Forget a cached item.
     *
     * @param string $key
     * 
     * @return bool
     */
    public function forget($key)
    {
        $this->forgetKey($key);

        return $this->store->forget('streams.' . $this->stream->handle . '.' . $key);
    }

    /**
     * Flush all cached items.
     * 
     * @return bool
     */
    public function flush()
    {
        $collectionKey = 'streams.' . $this->stream->handle . '_cache_collection';

        $collection = $this->collections->get($collectionKey, []);

        foreach ($collection as $key) {
            $this->store->forget($key);
        }

        return $this->collections->forget($collectionKey);
    }

    /**
     * Index a cache key.
     *
     * @param string $key
     */
    public function indexKey($key)
    {
        $collectionKey = 'streams.' . $this->stream->handle . '_cache_collection';

        $collection = $this->collections->get($collectionKey, []);

        if (in_array($key, $collection)) {
            return;
        }

        $collection[] = $key;

        $this->collections->put($collectionKey, array_unique($collection), 60 * 60 * 24 * 365);
    }

    /**
     * Forget a cache key.
     *
     * @param string $key
     */
    public function forgetKey($key)
    {
        $collectionKey = 'streams.' . $this->stream->handle . '_cache_collection';

        $collection = $this->collections->get($collectionKey, []);

        $collection = array_filter($collection, fn ($item) => $item !== $key);

        $this->collections->put($collectionKey, 3600, array_unique($collection));
    }
}
