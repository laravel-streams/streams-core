<?php

namespace Streams\Core\Field\Type;

use Streams\Core\Field\FieldType;
use Streams\Core\Field\Value\StrValue;

class Str extends FieldType
{

    public function modify($value)
    {
        if (is_null($value)) {
            return $value;
        }

        return (string) $value;
    }

    public function restore($value)
    {
        if (is_null($value)) {
            return $value;
        }

        return (string) $value;
    }

    public function expand($value)
    {
        return new StrValue($value);
    }

    public function generate()
    {
        $min = 100;
        $max = 200;

        if ($this->field->hasRule('max')) {
            $max = $this->field->ruleParameter('max');
        }

        if ($this->field->hasRule('min')) {
            $min = $this->field->ruleParameter('min');
        }

        return $this->generator()->text();
    }
}
