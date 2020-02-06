<?php

namespace Anomaly\Streams\Platform\Stream;

use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;

/**
 * Class StreamManager
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class StreamManager
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
     * Check if the stream exists.
     *
     * @param $key
     */
    public static function has($key)
    {
        return array_key_exists($key, self::$cache);
    }

    /**
     * Get a stream from cache.
     *
     * @param $key
     * @return StreamInterface
     */
    public static function get($key)
    {
        return self::$cache[$key];
    }
}
