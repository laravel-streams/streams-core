<?php namespace Anomaly\Streams\Platform\Support;

use Anomaly\Streams\Platform\Contract\PresentableInterface;
use Anomaly\Streams\Platform\Contract\StringableInterface;
use Illuminate\Contracts\Support\Arrayable;

/**
 * Class Presenter
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Support
 */
class Presenter implements \ArrayAccess, Arrayable
{

    /**
     * The resource payload.
     *
     * @var mixed
     */
    protected $resource;

    /**
     * Create a new Presenter instance.
     *
     * @param $resource
     */
    public function __construct($resource)
    {
        $this->resource = $resource;
    }

    /**
     * Alias for offsetGet()
     *
     * @param $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->offsetGet($key);
    }

    /**
     * Check for resource method and calls if it exists.
     *
     * @param       $key
     * @param array $arguments
     * @return mixed
     */
    public function __call($key, array $arguments = [])
    {
        if (method_exists($this->resource, $key)) {

            return call_user_func_array(array($this->resource, $key), $arguments);
        }
    }

    /**
     * Alias for offsetExists($key)
     *
     * @param $key
     * @return bool
     */
    public function __isset($key)
    {
        return $this->offsetExists($key);
    }

    /**
     * Set a property on the resource.
     *
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $this->resource->{$name} = $value;
    }

    /**
     * Unset a variable through the resource.
     *
     * @param string $name
     */
    public function __unset($name)
    {
        if (is_array($this->resource)) {

            unset($this->resource[$name]);

            return;
        }

        unset($this->resource->$name);
    }

    /**
     * Return the resource as a string.
     *
     * @return string
     */
    public function __toString()
    {
        if ($this->resource instanceof StringableInterface) {
            return $this->resource->toString();
        }

        return json_encode($this->resource);
    }

    /**
     * Return the resource as an array.
     *
     * @return array|null
     */
    public function toArray()
    {
        if ($this->resource instanceof Arrayable) {
            return $this->resource->toArray();
        } else {
            return null;
        }
    }

    /**
     * Check if an offset exists on the resource.
     *
     * @param mixed $key
     * @return bool
     */
    public function offsetExists($key)
    {
        if (method_exists($this, $key)) {
            return true;
        }

        if (is_array($this->resource) or $this->resource instanceof \ArrayAccess) {
            return isset($this->resource[$key]);
        } elseif (is_object($this->resource)) {
            return property_exists($this->resource, $key);
        }

        return false;
    }

    /**
     * Get the offset value from the resource.
     *
     * @param mixed $key
     * @return mixed
     */
    public function offsetGet($key)
    {
        if (method_exists($this, $key)) {
            return $this->{$key}();
        }

        if (is_array($this->resource) or $this->resource instanceof \ArrayAccess) {

            if ($this->resource instanceof PresentableInterface) {
                return $this->resource->toPresenter()->{$key};
            }

            return $this->resource[$key];
        } elseif (is_object($this->resource) and isset($this->resource->{$key})) {
            return $this->resource->{$key};
        }

        return null;
    }

    /**
     * Set a value to the resource.
     *
     * @param mixed $key
     * @param mixed $value
     */
    public function offsetSet($name, $value)
    {
        if (is_array($this->resource) or $this->resource instanceof \ArrayAccess) {
            if (is_null($name)) {
                $this->resource[] = $value;
            } else {
                $this->resource[$name] = $value;
            }
        } elseif (is_object($this->resource) and
            (property_exists($this->resource, $name) or isset($this->resource->{$name}))
        ) {
            $this->resource->{$name} = $value;
        }
    }

    /**
     * Unset an offset from the resource.
     *
     * @param mixed $name
     */
    public function offsetUnset($name)
    {
        if (is_array($this->resource) or $this->resource instanceof \ArrayAccess) {
            unset($this->resource[$name]);
        } elseif (is_object($this->resource) and isset($this->resource->{$name})) {
            unset($this->resource->{$name});
        }
    }

    /**
     * Get the resource.
     *
     * @return mixed
     */
    public function getResource()
    {
        return $this->resource;
    }
}
