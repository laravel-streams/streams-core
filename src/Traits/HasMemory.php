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
     * @param array $icon
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
}
