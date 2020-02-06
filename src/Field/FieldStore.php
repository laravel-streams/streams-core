<?php

namespace Anomaly\Streams\Platform\Field;

use Anomaly\Streams\Platform\Field\Contract\FieldInterface;

/**
 * Class FieldStore
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class FieldStore
{

    /**
     * The cached fields.
     *
     * @var array
     */
    protected static $cache = [];

    /**
     * Put a stream into cache.
     *
     * @param                 $key
     * @param FieldInterface $field
     */
    public static function put($key, FieldInterface $field)
    {
        self::$cache[$key] = $field;
    }

    /**
     * Check if the field exists.
     *
     * @param $key
     */
    public static function has($key)
    {
        return array_key_exists($key, self::$cache);
    }

    /**
     * Get a field from cache.
     *
     * @param $key
     * @return FieldInterface
     */
    public static function get($key)
    {
        return self::$cache[$key];
    }
}
