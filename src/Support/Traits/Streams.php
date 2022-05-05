<?php

namespace Streams\Core\Support\Traits;

use Illuminate\Support\Arr;
use Streams\Core\Stream\Stream;
use Illuminate\Support\Traits\ForwardsCalls;
use Streams\Core\Field\FieldDecorator;
use Streams\Core\Support\Facades\Streams as StreamsFacade;

/**
 * This class provides EntryInterface
 * support for eloquent models.
 * 
 * @property static $unguarded;
 */
trait Streams
{
    use ForwardsCalls;

    use Prototype {
        Prototype::__call as private callPrototype;
    }

    public function __construct(array $attributes = [])
    {
        
        //$this->loadPrototypeProperties($attributes);

        //$this->syncPrototypePropertyAttributes();
        $this->syncOriginalPrototypeAttributes($attributes);
    
        $this->syncOriginal();

        $this->setPrototypeProperties($this->stream()->fields->toArray());

        $this->setPrototypeAttributes($attributes);
    }

    public function fill(array $attributes)
    {
        parent::fill($attributes);

        $this->loadPrototypeAttributes($attributes);

        return;
    }

    public function getOriginal($key = null, $default = null)
    {
        $original = $this->getOriginalPrototypeAttributes();

        return $key ? Arr::get($original, $key, $default) : $original;
    }

    public function getAttribute($key)
    {
        return $this->getPrototypeAttribute($key);
    }

    public function setAttribute($key, $value)
    {
        $this->setPrototypeAttribute($key, $value);
        
        parent::setAttribute($key, $value);

        return $this;
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

    public function stream()
    {
        if ($this->stream && $this->stream instanceof Stream) {
            return $this->stream;
        }

        return $this->stream = StreamsFacade::make($this->stream);
    }

    public function decorate(string $key): FieldDecorator
    {
        return $this->decoratePrototypeAttribute($key);
    }

    public function validator()
    {
        return $this->stream()->validator($this);
    }

    public function setRawAttributes(array $attributes, $sync = false)
    {
        parent::setRawAttributes($attributes, $sync);

        $this->setRawPrototypeAttributes($attributes);

        if ($sync) {
            $this->syncOriginalPrototypeAttributes($attributes);
        }

        return $this;
    }

    public function lastModified()
    {
        return $this->updated_at ?: $this->created_at;
    }

    public function strict()
    {
        $attributes = $this->strict()->getAttributes();
        
    }

    public function getFillable()
    {
        return $this->fillable ?: $this->stream()->fields->keys()->all();
    }

    public function __set($key, $value)
    {
        parent::__set($key, $value);

        $this->setAttribute($key, $value);
    }

    public function __get($key)
    {
        return $this->getAttribute($key);
    }
}
