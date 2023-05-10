<?php

namespace Streams\Core\Field\Types;

use Streams\Core\Field\Field;
use Streams\Core\Field\Schema\IntegerSchema;
use Streams\Core\Field\Decorator\NumberDecorator;

class IntegerFieldType extends Field
{
    public $rules = [
        'nullable',
        'numeric',
        'integer',
    ];

    public function cast($value): int
    {
        if (is_string($value)) {
            $value = preg_replace('/[^\da-z\.\-]/i', '', $value);
        }

        return intval($value);
    }

    public function modify($value)
    {
        return $this->cast($value);
    }

    public function restore($value)
    {
        return $this->cast($value);
    }

    public function default($value)
    {
        if ($value == 'increment') {
            return $this->getNextIncrementValue();
        }

        return $this->cast($value);
    }

    public function generator()
    {
        $min = $this->ruleParameter('min');
        $max = $this->ruleParameter('max');


        if ($min || $max) {
            return function () use ($min, $max) {
                return $this->cast(fake()->numberBetween($min, $max));
            };
        }

        return function () {
            return $this->cast(fake()->randomNumber());
        };
    }

    public function getSchemaName()
    {
        return IntegerSchema::class;
    }

    public function getDecoratorName()
    {
        return NumberDecorator::class;
    }

    protected function getNextIncrementValue()
    {
        $last = $this->stream->entries()->orderBy($this->handle, 'DESC')->first();

        return $last ? $last->{$this->handle} + 1 : $this->ruleParameter('min', 0, 1);
    }
}
