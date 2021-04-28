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
     * @param $trigger
     * @param $callback
     * @return $this
     */
    public function on($trigger, $callback)
    {
        if (!isset($this->callbacks[$trigger])) {
            $this->callbacks[$trigger] = [];
        }

        $this->callbacks[$trigger][] = $callback;

        return $this;
    }

    /**
     * Register a new global listener.
     *
     * @param $trigger
     * @param $callback
     * @return $this
     */
    public static function when($trigger, $callback)
    {
        $trigger = static::class . '::' . $trigger;

        if (!isset(static::$listeners[$trigger])) {
            static::$listeners[$trigger] = [];
        }

        static::$listeners[$trigger][] = $callback;
    }

    /**
     * Fire a set of closures by trigger.
     *
     * @param        $trigger
     * @param  array $parameters
     * @return $this
     */
    public function fire($trigger, array $parameters = [])
    {

        /*
         * First, check if the method
         * exists and call it if it does.
         * 
         * This puts priority on the class.
         */
        $method = Str::camel('on_' . str_replace(['.'], '_', $trigger));

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
            static::class . '::' . $trigger
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
            $trigger
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
                if (method_exists($observer, $method = Str::camel($trigger))) {
                    App::call($observer . '@' . $method, $parameters);
                }
            }
        }

        return $this;
    }

    /**
     * Return if the callback exists.
     *
     * @param $trigger
     * @return bool
     */
    public function hasCallback($trigger)
    {
        return isset($this->callbacks[$trigger]);
    }

    /**
     * Return if the listener exists.
     *
     * @param $trigger
     * @return bool
     */
    public static function hasListener($trigger)
    {
        return isset(self::$listeners[static::class . '::' . $trigger]);
    }
}
