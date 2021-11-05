<?php

namespace Streams\Core\Field\Type;

use Illuminate\Support\Str;
use Streams\Core\Field\FieldType;
use Streams\Core\Field\Value\ArrValue;
use Illuminate\Contracts\Support\Arrayable;

class Arr extends FieldType
{
    protected $__attributes = [
        'rules' => [
            'array',
        ],
    ];

    public function modify($value)
    {
        if (is_null($value)) {
            return null;
        }

        if (is_array($value)) {
            return $value;
        }

        if (is_string($value) && $json = json_decode($value, true)) {
            return $json;
        }

        if (is_string($value) && Str::isSerialized($value, false)) {
            return (array) unserialize($value);
        }

        if (is_object($value) && $value instanceof Arrayable) {
            return $value->toArray();
        }

        return null;
    }

    public function restore($value)
    {
        if (is_null($value)) {
            return null;
        }

        if (is_string($value) && $json = json_decode($value, true)) {
            return $json;
        }

        if (is_string($value) && Str::isSerialized($value, false)) {
            return (array) unserialize($value);
        }

        return (array) $value;
    }

    public function expand($value)
    {
        return new ArrValue($value);
    }

    public function generate()
    {
        for ($i = 0; $i < 10; $i++) {
            $values[] = $this->generator()->randomElement([
                $this->generator()->word(),
                $this->generator()->randomNumber(),
            ]);
        }

        return $values;
    }
}
