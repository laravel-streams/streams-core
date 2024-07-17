<?php

namespace Streams\Core\Support\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Streams\Core\Stream\Stream;
use Illuminate\Validation\Validator;
use Streams\Core\Field\FieldDecorator;
use Illuminate\Support\Traits\ForwardsCalls;
use Illuminate\Database\Eloquent\Relations\Relation;
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

        $this->attributes = $this->getPrototypeAttributes();
    }

    function stream(): Stream
    {
        if (is_object($this->stream)) {
            return $this->stream;
        }

        return StreamsFacade::make($this->stream);
    }

    public function validator(): Validator
    {
        return $this->stream()->validator($this);
    }

    public function fill(array $attributes)
    {
        $this->loadPrototypeAttributes($attributes);

        parent::fill($this->getPrototypeAttributes());

        return;
    }

    public function save(array $options = []): bool
    {
        $stream = $this->stream();
        $attributes = $this->getAttributes();

        foreach ($stream->fields as $field) {

            if (array_key_exists($field->handle, $attributes) && !is_null($attributes[$field->handle])) {
                $attributes[$field->handle] = $field->modify($attributes[$field->handle]);
            }

            if (
                !array_key_exists($field->handle, $attributes)
                && !is_null($default = $field->config('default'))
            ) {
                $attributes[$field->handle] = $field->default($default);
            }
        }

        foreach ($attributes as &$value) {
            if (is_array($value)) {
                $value = json_encode($value);
            }
        }

        $this->attributes = $attributes;

        return parent::save($options);
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

    public function getKeyName()
    {
        return $this->stream()->config('key_name', 'id');
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

    public function decorate(string $key): FieldDecorator
    {
        return $this->decoratePrototypeAttribute($key);
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
        if (isset($this->relationships) && in_array($key, $this->relationships)) {

            $related = $this->{Str::camel($key)}();

            if ($related instanceof Relation) {
                $related = $related->getResults();
            }

            return $related;
        }

        return $this->getAttribute($key);
    }

    public function __call($method, $parameters)
    {
        try {
            return $this->callPrototype($method, $parameters);
        } catch (\Exception $e) {
            return parent::__call($method, $parameters);
        }
    }
}
