<?php

namespace Streams\Core\Field;

use JsonSerializable;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Streams\Core\Field\FieldType;
use Illuminate\Support\Facades\App;
use Illuminate\Contracts\Support\Jsonable;
use Streams\Core\Support\Facades\Hydrator;
use Streams\Core\Support\Traits\HasMemory;
use Streams\Core\Support\Traits\Prototype;
use Illuminate\Contracts\Support\Arrayable;

class Field implements
    JsonSerializable,
    Arrayable,
    Jsonable
{
    use HasMemory;
    use Prototype;

    /**
     * Return the field's name.
     * 
     * @return string
     */
    public function name()
    {
        return $this->name ?: ($this->name = Str::title(Str::humanize($this->handle)));
    }

    /**
     * Return the type instance.
     * 
     * @return FieldType
     */
    public function type(array $attributes = [])
    {
        return $this->once($this->handle . '.' . $this->type, function () use ($attributes) {

            $attributes['field'] = $this;

            $type = App::make('streams.core.field_type.' . $this->type, [
                'attributes' => $attributes,
            ]);

            return $type;
        });
    }

    public function hasRule($rule)
    {
        return $this->stream->hasRule($this->handle, $rule);
    }

    public function getRule($rule)
    {
        return $this->stream->getRule($this->handle, $rule);
    }

    public function ruleParameters($rule)
    {
        return $this->stream->ruleParameters($this->handle, $rule);
    }

    public function ruleParameter($rule, $key = 0)
    {
        return Arr::get($this->ruleParameters($rule), $key);
    }

    public function isRequired()
    {
        return $this->stream->isRequired($this->handle);
    }

    public function toArray()
    {
        return Hydrator::dehydrate($this, [
            'stream',
        ]);
    }

    /**
     * Specify data which should
     * be serialized to JSON.
     * 
     * @return mixed
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public function toJson($options = 0): string
    {
        return json_encode($this->toArray(), $options);
    }

    /**
     * Return a string representation.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toJson();
    }
}
