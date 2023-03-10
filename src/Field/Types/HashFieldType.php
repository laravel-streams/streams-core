<?php

namespace Streams\Core\Field\Types;

use Streams\Core\Field\Field;
use Illuminate\Support\Facades\Hash;
use Streams\Core\Field\Schema\HashSchema;
use Streams\Core\Field\Decorator\HashDecorator;

class HashFieldType extends Field
{
    public function cast($value)
    {
        if (strpos($value, '$2y$') === 0 && strlen($value) == 60) {
            return $value;
        }

        return Hash::make($value);
    }

    public function getSchemaName()
    {
        return HashSchema::class;
    }

    public function getDecoratorName()
    {
        return HashDecorator::class;
    }

    public function generator()
    {
        return function () {

            $min = $this->ruleParameter('min');
            $max = $this->ruleParameter('max');

            return Hash::make(fake()->password($min ?: 6, $max ?: 20));
        };
    }
}
