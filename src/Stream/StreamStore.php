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
     * @param                 $key
     * @param StreamInterface $stream
     */
    public static function put($key, StreamInterface $stream)
    {
        self::$cache[$key] = $stream;
    }

    /**
     * Get a stream from cache.
     *
     * @param $data
     * @return null|StreamInterface
     */
    public static function get($stream)
    {
        if (isset(self::$cache[$key = self::key($stream)])) {
            return self::$cache[$key];
        }

        return null;
    }

    /**
     * Get the cache key.
     *
     * @param  array  $data
     * @return string
     */
    public static function key($stream)
    {
        return md5(json_encode($stream));
    }
}
