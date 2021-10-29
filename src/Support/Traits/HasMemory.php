<?php

namespace Streams\Core\Support\Traits;

/**
 * Trait HasMemory
 *
 * @link   http://pyrocms.com/
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
trait HasMemory
{

    /**
     * The static memory.
     *
     * @var array
     */
    protected static $memory = [];

    /**
     * Remember something.
     *
     * @param string $key
     * @param callable $callable
     * @return null|string
     */
    public static function remember($key, $callable)
    {
        $prefix = self::class;

        if (array_key_exists($prefix . $key, self::$memory)) {
            return self::$memory[$prefix . $key];
        }

        return self::$memory[$prefix . $key] = call_user_func($callable);
    }

    /**
     * Remember something across all instances.
     *
     * @param string $key
     * @param callable $callable
     * @return mixed
     */
    public static function once($key, $callable)
    {
        if (array_key_exists($key, self::$memory)) {
            return self::$memory[$key];
        }

        return self::$memory[$key] = call_user_func($callable);
    }

    /**
     * Forget a key.
     *
     * @param string $key
     */
    public static function forget($key)
    {
        $prefix = self::class;

        if (array_key_exists($prefix . $key, self::$memory)) {
            unset(self::$memory[$prefix . $key]);
        }

        if (array_key_exists($key, self::$memory)) {
            unset(self::$memory[$key]);
        }
    }

    /**
     * Reset memory.
     */
    public static function resetMemory()
    {
        self::$memory = [];
    }
}
