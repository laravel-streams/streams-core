<?php

namespace Streams\Core\Field\Types;

use Streams\Core\Field\Field;
use Streams\Core\Field\Schema\DecimalSchema;
use Streams\Core\Field\Decorator\NumberDecorator;

class DecimalFieldType extends Field
{
    public $rules = [
        'numeric',
        'nullable',
    ];

    public function modify($value)
    {
        return $this->cast($value);
    }

    public function restore($value)
    {
        return $this->cast($value);
    }

    public function cast($value): float
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

        if ($precision = $this->config('precision')) {
            $value = round($value, $precision);
        }

        return $value;
    }

    public function generator()
    {
        $min = $this->ruleParameter('min');
        $max = $this->ruleParameter('max');

        if ($min || $max) {
            return function () use ($min, $max) {
                return $this->cast(fake()->randomFloat(null, $min, $max));
            };
        }

        return function () {
            return $this->cast(fake()->randomFloat());
        };
    }

    public function getSchemaName()
    {
        return DecimalSchema::class;
    }

    public function getDecoratorName()
    {
        return NumberDecorator::class;
    }
}
