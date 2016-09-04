<?php namespace Anomaly\Streams\Platform\Support;

use Illuminate\Contracts\Config\Repository;

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
     * Map to get.
     *
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->get($name);
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
