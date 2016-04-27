<?php namespace Anomaly\Streams\Platform\Traits;

use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class Hookable
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Traits
 */
trait Hookable
{

    /**
     * The registered hooks.
     *
     * @var array
     */
    protected static $hooks = [];

    /**
     * Register a new hook.
     *
     * @param $hook
     * @param $callback
     * @return $this
     */
    public function hook($hook, $callback)
    {
        self::$hooks[get_class($this) . $hook] = $callback;

        return $this;
    }

    /**
     * Fire a set of closures by trigger.
     *
     * @param       $hook
     * @param array $parameters
     * @return mixed
     */
    public function call($hook, array $parameters = [])
    {
        return app()->call(self::$hooks[get_class($this) . $hook], $parameters);
    }

    /**
     * Return if the hook exists.
     *
     * @param $hook
     * @return bool
     */
    public function hasHook($hook)
    {
        return isset(self::$hooks[get_class($this) . $hook]);
    }
}
