<?php

namespace Streams\Core\Support\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\App;

/**
 * This class adds versatile callback functionality to objects.
 */
trait FiresCallbacks
{

    protected array $__callbacks = [];

    public static array $__listeners = [];

    public static array $__observers = [];

    /**
     * Register observers with the instance.
     *
     * @param object|array|string  $classes
     * @return void
     */
    public static function observeCallbacks($classes): void
    {
        // @todo Alternatively we could push this into $__listeners
        foreach (Arr::wrap($classes) as $class) {
            self::$__observers[static::class][] = $class;
        }
    }

    /**
     * Register a new callback.
     *
     * @param string $name
     * @param \Closure|string|object $callback
     * @return $this
     */
    public function addCallback(string $name, $callback)
    {
        if (!isset($this->__callbacks[$name])) {
            $this->__callbacks[$name] = [];
        }

        $this->__callbacks[$name][] = $callback;

        return $this;
    }

    /**
     * Register a new global listener.
     *
     * @param string $name
     * @param \Closure|string|object $callback
     * @return $this
     */
    public static function addCallbackListener(string $name, $callback)
    {
        $name = static::class . '::' . $name;

        if (!isset(static::$__listeners[$name])) {
            static::$__listeners[$name] = [];
        }

        static::$__listeners[$name][] = $callback;
    }

    /**
     * Fire a set of closures by trigger.
     *
     * @param string $name
     * @param  array $parameters
     * @return $this
     */
    public function fire(string $name, array $parameters = [])
    {

        /*
         * First, check if the method
         * exists and call it if it does.
         * 
         * This puts priority on the class.
         */
        $method = Str::camel('on_' . str_replace(['.'], '_', $name));

        if (method_exists($this, $method)) {
            App::call([$this, $method], $parameters);
        }

        /*
         * Next, run through all of
         * the global callbacks.
         * 
         * Priority moves to global callbacks.
         */
        $listeners = (array) Arr::get(
            self::$__listeners,
            static::class . '::' . $name
        );

        foreach ($listeners as $callback) {
            App::call($callback, $parameters);
        }

        /*
         * Next, run through all of
         * the registered callbacks.
         * 
         * Priority moves to this instance.
         */
        $callbacks = (array) Arr::get(
            $this->__callbacks,
            $name
        );

        foreach ($callbacks as $callback) {
            App::call($callback, $parameters);
        }

        /**
         * Lastly, let any observers
         * know about the callback.
         */
        if (isset(self::$__observers[static::class])) {
            foreach (self::$__observers[static::class] as $observer) {
                if (method_exists($observer, $method = Str::camel($name))) {
                    App::call($observer . '@' . $method, $parameters);
                }
            }
        }

        return $this;
    }

    /**
     * Return whether the callback exists.
     *
     * @param string $name
     * @return bool
     */
    public function hasCallback(string $name): bool
    {
        return isset($this->__callbacks[$name]);
    }

    /**
     * Return whether a callback listener exists.
     *
     * @param string $name
     * @return bool
     */
    public static function hasCallbackListener(string $name): bool
    {
        return isset(self::$__listeners[static::class . '::' . $name]);
    }
}
