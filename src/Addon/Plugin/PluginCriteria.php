<?php namespace Anomaly\Streams\Platform\Addon\Plugin;

use Anomaly\Streams\Platform\Support\Collection;
use Closure;

/**
 * Class PluginCriteria
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Plugin
 */
class PluginCriteria
{

    /**
     * The options.
     *
     * @var array
     */
    protected $options = [];

    /**
     * The callback trigger.
     *
     * @var string
     */
    protected $trigger;

    /**
     * The resolving callback.
     *
     * @var Closure
     */
    protected $callback;

    /**
     * Create a new PluginCriteria instance.
     *
     * @param         $trigger
     * @param Closure $callback
     */
    public function __construct($trigger, Closure $callback)
    {
        $this->trigger  = $trigger;
        $this->callback = $callback;
    }

    /**
     * Route through __call
     *
     * @param $name
     * @return mixed
     */
    function __get($name)
    {
        return $this->__call($name, []);
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed|$this
     */
    function __call($name, $arguments)
    {
        if ($name == $this->trigger) {
            return call_user_func($this->callback, new Collection($this->options));
        }

        if (method_exists($this, $name)) {
            return call_user_func_array([$this, $name], $arguments);
        }

        array_set($this->options, snake_case($name), array_shift($arguments));

        return $this;
    }

    /**
     * Trigger on toString.
     *
     * @return string
     */
    function __toString()
    {
        return $this->{$this->trigger};
    }
}
