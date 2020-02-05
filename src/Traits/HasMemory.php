<?php

namespace Anomaly\Streams\Platform\Traits;

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
     * @param CLosure $callable
     * @return null|string
     */
    public function remember($key, $callable)
    {
        $prefix = get_class($this);

        if (array_key_exists($prefix . $key, self::$memory)) {
            return self::$memory[$prefix . $key];
        }

        return self::$memory[$prefix . $key] = app()->call($callable, ['self' => $this]);
    }

    /**
     * Remember something across all instances.
     *
     * @param string $key
     * @param CLosure $callable
     * @return null|string
     */
    public function once($key, $callable)
    {
        if (array_key_exists($key, self::$memory)) {
            return self::$memory[$key];
        }

        return self::$memory[$key] = app()->call($callable, ['self' => $this]);
    }
}
