<?php

namespace Streams\Core\Field\Types\Validation;

use Streams\Core\Field\Types\ColorFieldType;
use Illuminate\Contracts\Validation\InvokableRule;

class ValidateColorValue implements InvokableRule
{
    public function __construct(protected ColorFieldType $field)
    {
    }

    public function __invoke($attribute, $value, $fail)
    {
        try {
            $this->field->decorate($value)->levels();
        } catch (\Exception) {
            return $fail('The :attribute is not a valid color.');
        }
    }
}
