<?php

namespace Streams\Core\Field\Type;

use Illuminate\Support\Str;
use Streams\Core\Field\FieldType;
use Streams\Core\Field\Value\ArrValue;
use Illuminate\Support\Arr as ArrFacade;
use Illuminate\Contracts\Support\Arrayable;
use Streams\Core\Support\Facades\Hydrator;

class Arr extends FieldType
{
    protected $__attributes = [
        'rules' => [
            'array',
        ],
    ];

    public function cast($value): array
    {
        if (is_string($value) && $json = json_decode($value, true)) {
            return $json;
        }

        if (is_string($value) && Str::isSerialized($value, false)) {
            return (array) unserialize($value);
        }

        if (is_object($value) && $value instanceof Arrayable) {
            return $value->toArray();
        }
        
        if (is_object($value)) {
            return Hydrator::dehydrate($value);
        }

        return (array) $value;
    }

    public function modify($value)
    {
        if (is_string($value) && $json = json_decode($value, true)) {
            return $json;
        }

        if (is_string($value) && Str::isSerialized($value, false)) {
            return (array) unserialize($value);
        }

        if (is_object($value) && $value instanceof Arrayable) {
            return $value->toArray();
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
