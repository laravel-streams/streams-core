<?php

namespace Anomaly\Streams\Platform\Traits;

use Illuminate\Support\Facades\App;

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
    protected static $listeners = [];

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

        if (!isset(self::$listeners[$trigger])) {
            self::$listeners[$trigger] = [];
        }

        self::$listeners[$trigger][] = $callback;
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

        /**
         * First, fire global listeners.
         */
        $classes = array_merge(
            class_parents($this),
            [static::class => static::class]
        );

        foreach (array_keys($classes) as $caller) {

            $listeners = (array) array_get(
                self::$listeners,
                $caller . '::' . $trigger
            );

            foreach ($listeners as $callback) {
                App::call($callback, $parameters);
            }
        }

        /*
         * Next, check if the method
         * exists and call it if it does.
         */
        $method = camel_case('on_' . $trigger);

        if (method_exists($this, $method)) {
            App::call([$this, $method], $parameters);
        }

        /*
         * Finally, run through all of
         * the registered callbacks.
         */
        $callbacks = (array) array_get(
            $this->callbacks,
            $trigger
        );

        foreach ($callbacks as $callback) {
            App::call($callback, $parameters);
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
