<?php

namespace Streams\Core\Support\Traits;

use Streams\Core\Stream\Stream;
use Illuminate\Validation\Validator;
use Illuminate\Support\Traits\ForwardsCalls;
use Streams\Core\Support\Facades\Streams as StreamsFacade;

/**
 * Trait Streams
 * 
 * @link   http://pyrocms.com/
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
trait Streams
{

    use ForwardsCalls;

    use Prototype {
        Prototype::__call as private callPrototype;
    }

    /**
     * Create a new Eloquent model instance.
     *
     * @param  array  $attributes
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        $this->loadPrototypeProperties($attributes);

        $attributes = array_merge_recursive($this->getPrototypeAttributes(), $attributes);

        $this->setPrototypeAttributes($attributes);

        $this->__prototype['original'] = $this->__prototype['attributes'];

        parent::__construct($attributes);
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

    public function hasAttribute($key)
    {
        return $this->hasPrototypeAttribute($key);
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
     * Return the entry validator.
     * 
     * @return Validator
     */
    public function validator()
    {
        return $this->stream()->validator($this);
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

        $this->initializePrototypeAttributes($attributes);

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
        } catch (\Exception $e) {
            return $this->callPrototype($method, $arguments);
        }

        $this->forwardCallTo($this->newQuery(), $method, $arguments);
    }

    /**
     * Try Eloquent model but fallback to ours. 
     *
     * @param $method
     * @param $arguments
     * @return mixed
     */
    public static function __callStatic($method, $arguments)
    {
        try {
            return parent::__callStatic($method, $arguments);
        } catch (\Exception $e) {
            return call_user_func_array([(new static)->newQuery(), $method], $arguments);
        }
    }
}
