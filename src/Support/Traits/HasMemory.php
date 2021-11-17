<?php

namespace Streams\Core\Support\Traits;

/**
 * This class provides a semi-aware
 * runtime cache for any object.
 */
trait HasMemory
{

    protected static array $memory = [];

    public static function remember(string $key, callable $callable)
    {
        return self::once(self::class . $key, $callable);
    }

    public static function once(string $key, callable $callable)
    {
        if (array_key_exists($key, self::$memory)) {
            return self::$memory[$key];
        }

        return self::$memory[$key] = call_user_func($callable);
    }

    public static function forget(string $key): void
    {
        $prefix = self::class;

        if (array_key_exists($prefix . $key, self::$memory)) {
            unset(self::$memory[$prefix . $key]);
        }

        if (array_key_exists($key, self::$memory)) {
            unset(self::$memory[$key]);
        }
    }

    public static function resetMemory(): void
    {
        self::$memory = [];
    }
}
