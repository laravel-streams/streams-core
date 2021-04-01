<?php

namespace Streams\Core\Support\Traits;

use Exception;
use Streams\Core\Stream\Stream;
use Streams\Core\Support\Facades\Streams as StreamsFacade;

/**
 * Trait Streams
 * 
 * @link   http://pyrocms.com/
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
trait Streams
{

    use Prototype {
        Prototype::__call as private callPrototype;
    }

    /**
     * Mirror attribute changes.
     *
     * @param array $attributes
     * @return Self
     */
    public function fill(array $attributes)
    {
        $this->loadPrototypeAttributes($attributes);

        return parent::fill($attributes);
    }

    /**
     * Mirror attribute changes.
     *
     * @param string $key
     * @param mixed $value
     * @return mixed
     */
    public function setAttribute($key, $value)
    {
        $this->setPrototypeAttribute($key, $value);

        return parent::setAttribute($key, $value);
    }

    public function setAttributes(array $attributes)
    {

        $this->fill($attributes);
        $this->setPrototypeAttributes($attributes);

        return $this;
    }

    /**
     * Return the stream instance.
     */
    public function stream()
    {
        if ($this->stream && $this->stream instanceof Stream) {
            return $this->stream;
        }

        if (!$this->stream) {
            $this->stream = $this->table;
        }

        return $this->stream = StreamsFacade::make($this->stream);
    }

    /**
     * Expand field values.
     *
     * @param string $key
     */
    public function expand($key)
    {
        return $this->expandPrototypeAttribute($key);
    }

    /**
     * Mirror attribute changes.
     *
     * @param array $attributes
     * @param bool $sync
     */
    public function setRawAttributes(array $attributes, $sync = false)
    {
        parent::setRawAttributes($attributes, $sync);

        $this->initializePrototype($attributes);

        if ($sync) {
            $this->__prototype['original'] = $this->__prototype['attributes'];
        }
    }

    /**
     * Mirror attribute changes.
     *
     * @param string $key
     * @param mixed $value
     */
    public function __set($key, $value)
    {
        parent::__set($key, $value);

        $this->setPrototypeAttributeValue($key, $value);
    }

    /**
     * Try Eloquent model but fallback to ours. 
     *
     * @param $method
     * @param $arguments
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        try {
            return parent::__call($method, $arguments);
        } catch (Exception $e) {
            return $this->callPrototype($method, $arguments);
        }

        throw new \BadMethodCallException(sprintf(
            'Method %s::%s does not exist.',
            static::class,
            $method
        ));
    }
}
