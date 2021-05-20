<?php

namespace Streams\Core\Support\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Streams\Core\Field\Field;

/**
 * Class FiresCallbacks
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
trait FiresCallbacks
{

    /**
     * The local callbacks.
     *
     * @var array
     */
    protected $callbacks = [];

    /**
     * The static callbacks.
     *
     * @var array
     */
    public static $listeners = [];

    /**
     * The static observers.
     *
     * @var array
     */
    public static $observers = [];

    /**
     * Register observers with the instance.
     *
     * @param  object|array|string  $classes
     */
    public static function observeCallbacks($classes)
    {
        // @todo Alternatively we could push this into $listeners
        foreach (Arr::wrap($classes) as $class) {
            self::$observers[static::class][] = $class;
        }
    }

    /**
     * Register a new callback.
     *
     * @param $name
     * @param $callback
     * @return $this
     */
    public function addCallback($name, $callback)
    {
        if (!isset($this->callbacks[$name])) {
            $this->callbacks[$name] = [];
        }

        $this->callbacks[$name][] = $callback;

        return $this;
    }

    /**
     * Register a new global listener.
     *
     * @param $name
     * @param $callback
     * @return $this
     */
    public static function addCallbackListener($name, $callback)
    {
        $name = static::class . '::' . $name;

        if (!isset(static::$listeners[$name])) {
            static::$listeners[$name] = [];
        }

        static::$listeners[$name][] = $callback;
    }

    /**
     * Fire a set of closures by trigger.
     *
     * @param        $name
     * @param  array $parameters
     * @return $this
     */
    public function fire($name, array $parameters = [])
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
            self::$listeners,
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
            $this->callbacks,
            $name
        );

        foreach ($callbacks as $callback) {
            App::call($callback, $parameters);
        }

        /**
         * Lastly, let any observers
         * know about the callback.
         */
        if (isset(self::$observers[static::class])) {
            foreach (self::$observers[static::class] as $observer) {
                if (method_exists($observer, $method = Str::camel($name))) {
                    App::call($observer . '@' . $method, $parameters);
                }
            }
        }

        return $this;
    }

    /**
     * Return if the callback exists.
     *
     * @param $name
     * @return bool
     */
    public function hasCallback($name)
    {
        return isset($this->callbacks[$name]);
    }

    /**
     * Return if the listener exists.
     *
     * @param $name
     * @return bool
     */
    public static function hasCallbackListener($name)
    {
        return isset(self::$listeners[static::class . '::' . $name]);
    }
}
