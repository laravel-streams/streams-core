<?php namespace Anomaly\Streams\Platform\Addon\Plugin;

use Anomaly\Streams\Platform\Support\Collection;
use Closure;

/**
 * Class PluginCriteria
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
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
     * The options collection.
     *
     * @var Collection
     */
    protected $collection = Collection::class;

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
     * Return an option value.
     *
     * @param        $key
     * @param  null  $default
     * @return mixed
     */
    public function option($key, $default = null)
    {
        return array_get($this->options, $key, $default);
    }

    /**
     * Get the options.
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Set the options.
     *
     * @param array $options
     */
    public function setOptions(array $options = [])
    {
        $this->options = $options;
    }

    /**
     * Get the collection.
     *
     * @return string
     */
    public function getCollection()
    {
        return $this->collection;
    }

    /**
     * Set the collection.
     *
     * @param $collection
     * @return $this
     */
    public function setCollection($collection)
    {
        $this->collection = $collection;

        return $this;
    }

    /**
     * Return a new collection.
     *
     * @return Collection
     */
    public function newCollection()
    {
        $collection = $this->getCollection();

        return new $collection($this->getOptions());
    }

    /**
     * Route through __call
     *
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->__call($name, []);
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed|$this
     */
    public function __call($name, $arguments)
    {
        if ($name == $this->trigger) {
            return app()->call(
                $this->callback,
                [
                    'options'  => $this->newCollection(),
                    'criteria' => $this,
                ]
            );
        }

        if (method_exists($this, $name)) {
            return call_user_func_array([$this, $name], $arguments);
        }

        if (count($arguments) == 1) {
            array_set($this->options, snake_case($name), array_shift($arguments));
        } else {
            array_set($this->options, snake_case($name), $arguments);
        }

        return $this;
    }

    /**
     * Trigger on toString.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->{$this->trigger};
    }
}
