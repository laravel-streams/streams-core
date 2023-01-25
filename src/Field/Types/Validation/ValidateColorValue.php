<?php

namespace Streams\Core\Field\Types\Validation;

use Streams\Core\Field\Types\ColorFieldType;

class ValidateColorValue
{
    public function __invoke(ColorFieldType $field, $value): bool
    {
        try {
            $field->decorate($value)->levels();
        } catch (\Exception) {
            return false;
        }

        return true;
    }
}
