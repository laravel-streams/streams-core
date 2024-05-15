<?php

namespace Streams\Core\Field\Types;

use Streams\Core\Field\Field;
use Streams\Core\Field\Decorator\NumberDecorator;
use Streams\Core\Field\Schema\NumberSchema;

class NumberFieldType extends Field
{
    public $rules = [
        'numeric',
        'nullable',
    ];

    public function cast($value): float|int
    {
        if (is_string($value)) {
            $value = preg_replace('/[^\da-z\.\-]/i', '', $value);
        }

        $float = floatval($value);

        if ($float && intval($float) != $float) {
            $value = $float;
        } else {
            $value = intval($value);
        }

        return $value;
    }

    public function default($value)
    {
        return $this->cast($value);
    }

    public function modify($value)
    {
        return $this->cast($value);
    }

    public function restore($value)
    {
        return $this->cast($value);
    }

    public function generator()
    {
        $min = $this->ruleParameter('min');
        $max = $this->ruleParameter('max');

        if ($min || $max) {
            return function () use ($min, $max) {
                return fake()->randomElement([
                    fake()->numberBetween($min ?: 0, $max ?: 2147483647),
                    fake()->randomFloat(null, $min ?: 0, $max),
                ]);
            };
        }
        return function () {
            return fake()->randomElement([
                fake()->randomNumber(),
                fake()->randomFloat(),
            ]);
        };
    }

    public function getSchemaName()
    {
        return NumberSchema::class;
    }

    public function getDecoratorName()
    {
        return NumberDecorator::class;
    }
}
