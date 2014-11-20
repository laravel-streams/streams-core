<?php namespace Anomaly\Streams\Platform\Support;

use Anomaly\Streams\Platform\Contract\ArrayableInterface;
use Anomaly\Streams\Platform\Contract\PresentableInterface;

/**
 * Class Presenter
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Support
 */
class Presenter implements ArrayableInterface, \ArrayAccess
{

    /**
     * The resource payload.
     *
     * @var
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
     * Magic Method access initially tries for local
     * methods then, defers to the decorated object.
     *
     * @param $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->offsetGet($key);
    }

    /**
     * Magic Method access for methods called against the presenter looks for
     * a method on the resource or returns null if none is found.
     *
     * @param $key
     * @param $args
     * @return mixed
     */
    public function __call($key, array $params = [])
    {
        if (method_exists($this->resource, $key)) {

            return call_user_func_array(array($this->resource, $key), $params);
        }
    }

    /**
     * Magic Method isset access measures the existence
     * of a property on the resource using ArrayAccess.
     *
     * @param $key
     * @return bool
     */
    public function __isset($key)
    {
        return $this->offsetExists($key);
    }

    /**
     * Set property values on the resource.
     *
     * @param $property
     * @param $value
     */
    public function __set($property, $value)
    {
        $this->resource->{$property} = $value;
    }

    /**
     * Unset a variable through the presenter.
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
     * Magic Method toString is deferred to the resource.
     *
     * @return string
     */
    public function __toString()
    {
        if (is_object($this->resource) and method_exists($this->resource, '__toString')) {

            return $this->resource->__toString();
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
        if ($this->resource instanceof ArrayableInterface) {

            return $this->resource->toArray();
        } else {

            return null;
        }
    }

    /**
     * ArrayAccess interface - check the existence of a property / key.
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
     * ArrayAccess interface - get the offset value.
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

                return $this->resource->decorate()->{$key};
            }

            return $this->resource[$key];
        } elseif (is_object($this->resource) and isset($this->resource->{$key})) {

            return $this->resource->{$key};
        }

        return null;
    }

    /**
     * ArrayAccess interface - set the offset value.
     *
     * @param mixed $key
     * @param mixed $value
     */
    public function offsetSet($key, $value)
    {
        if (is_array($this->resource) or $this->resource instanceof \ArrayAccess) {

            if (is_null($key)) {

                $this->resource[] = $value;
            } else {

                $this->resource[$key] = $value;
            }
        } elseif (is_object($this->resource) and
            (property_exists($this->resource, $key) or isset($this->resource->{$key}))
        ) {

            $this->resource->{$key} = $value;
        }
    }

    /**
     * ArrayAccess interface - unset the offset value.
     *
     * @param mixed $key
     */
    public function offsetUnset($key)
    {
        if (is_array($this->resource) or $this->resource instanceof \ArrayAccess) {

            unset($this->resource[$key]);
        } elseif (is_object($this->resource) and isset($this->resource->{$key})) {

            unset($this->resource->{$key});
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
