<?php

namespace Streams\Core\Field\Types;

use Streams\Core\Field\Field;
use Streams\Core\Field\Schema\DecimalSchema;
use Streams\Core\Field\Decorator\NumberDecorator;

class DecimalFieldType extends Field
{
    public $rules = [
        'numeric',
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

        return round($value, $this->config('precision') ?: 1);
    }

    public function getSchemaName()
    {
        return DecimalSchema::class;
    }

    public function getDecoratorName()
    {
        return NumberDecorator::class;
    }

    // public function generate()
    // {
    //     return $this->cast($this->generator()->randomElement([
    //         $this->generator()->randomNumber(),
    //         $this->generator()->randomFloat(),
    //         round($this->generator()->randomFloat(), 1),
    //     ]));
    // }
}
