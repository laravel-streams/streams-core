<?php namespace Anomaly\Streams\Platform\Support;

/**
 * Class Collection
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Collection extends \Illuminate\Support\Collection
{

    /**
     * Alias for pluck.
     *
     * @deprecated in 3.1. Will remove in 3.2
     *
     * @param string $value
     * @param string $key
     *
     * @return $this
     */
    public function lists($value, $key = null)
    {
        return self::pluck($value, $key);
    }

    /**
     * Pad to the specified size with a value.
     *
     * @param        $size
     * @param  null  $value
     * @return $this
     */
    public function pad($size, $value = null)
    {
        if ($this->isEmpty()) {
            return $this;
        }

        return new static(array_pad($this->items, $size, $value));
    }

    /**
     * An alias for slice.
     *
     * @param $offset
     * @return $this
     */
    public function skip($offset)
    {
        return $this->slice($offset, null, true);
    }

    /**
     * Return undecorated items.
     *
     * @return static|$this
     */
    public function undecorate()
    {
        return new static((new Decorator())->undecorate($this->items));
    }

    /**
     * Map to get.
     *
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        if ($this->has($name)) {
            return $this->get($name);
        }

        return call_user_func([$this, camel_case($name)]);
    }

    /**
     * Map to get.
     *
     * @param string $method
     * @param array  $parameters
     */
    public function __call($method, $parameters)
    {
        return $this->get($method);
    }
}
