<?php

namespace Anomaly\Streams\Platform\Stream;

use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;

/**
 * Class StreamStore
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class StreamStore
{

    /**
     * The cached streams.
     *
     * @var array
     */
    protected static $cache = [];

    /**
     * Put a stream into cache.
     *
     * @param                 $data
     * @param StreamInterface $stream
     */
    public static function put(StreamInterface $stream)
    {
        self::$cache[self::cacheKey($stream)] = $stream;
    }

    /**
     * Get a stream from cache.
     *
     * @param $data
     * @return null|StreamInterface
     */
    public static function get($namespace, $slug)
    {
        if (isset(self::$cache["{$namespace}.{$slug}"])) {
            return self::$cache["{$namespace}.{$slug}"];
        }

        return null;
    }

    /**
     * Get the cache key.
     *
     * @param  array  $data
     * @return string
     */
    protected static function cacheKey(StreamInterface $stream)
    {
        return "{$stream->namespace}.{$stream->slug}";
    }
}
