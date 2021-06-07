<?php

namespace Streams\Core\Field;

use JsonSerializable;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Streams\Core\Field\FieldType;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Contracts\Support\Jsonable;
use Streams\Core\Support\Facades\Hydrator;
use Streams\Core\Support\Traits\HasMemory;
use Streams\Core\Support\Traits\Prototype;
use Illuminate\Contracts\Support\Arrayable;
use Streams\Core\Support\Traits\FiresCallbacks;

class Field implements
    JsonSerializable,
    Arrayable,
    Jsonable
{
    use HasMemory;
    use Prototype;
    use Macroable;
    use FiresCallbacks;

    /**
     * Create a new class instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $callbackData = new Collection([
            'attributes' => $attributes,
        ]);

        $this->fire('initializing', [
            'callbackData' => $callbackData,
        ]);

        $this->initializePrototypeAttributes($callbackData->get('attributes'));
        
        $this->fire('initialized', [
            'field' => $this,
        ]);
    }

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

            if (!App::has('streams.core.field_type.' . $this->type)) {
                throw new \Exception("Invalid type [{$this->type}] in stream [{$this->stream->handle}]");
            }

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




    public function onInitializing($callbackData)
    {
        $attributes = $callbackData->get('attributes');

        $this->normalizeInput($attributes);

        $callbackData->put('attributes', $attributes);
    }

    public function normalizeInput(&$attributes)
    {
        if (!isset($attributes['type'])) {
            $attributes['type'] = $attributes['handle'];
        }

        $attributes['rules'] = Arr::get($attributes, 'rules', []);

        if (is_string($attributes['rules'])) {
            $attributes['rules'] = explode('|', $attributes['rules']);
        }

        if (Arr::pull($attributes, 'required') == true) {
            $attributes['rules'][] = 'required';
        }

        /**
         * Unique Rule
         */
        array_walk($attributes['rules'], function (&$rule) use ($attributes) {

            if (Str::startsWith($rule, 'unique')) {

                $parts = explode(':', $rule);
                $parameters = array_filter(explode(',', Arr::get($parts, 1)));

                if (!$parameters) {
                    $parameters[] = $attributes['stream']->handle;
                }

                if (count($parameters) === 1) {
                    $parameters[] = $attributes['handle'];
                }

                // if (count($parameters) === 2 && $this->entry && $ignore = $this->entry->{$field}) {
                //     $parameters[] = $ignore;
                //     $parameters[] = $field;
                // }

                $rule = 'unique:' . implode(',', $parameters);
            }
        });

        $attributes = Arr::undot($attributes);
    }
}
