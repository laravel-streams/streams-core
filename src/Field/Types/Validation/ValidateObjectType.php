<?php

namespace Streams\Core\Field\Types\Validation;

use Streams\Core\Field\Types\ObjectFieldType;

class ValidateObjectType
{
    public function __invoke(ObjectFieldType $field, $value): bool
    {
        if (!is_object($value)) {
            return false;
        }

        if (!$types = $field->config('allowed')) {
            return true;
        }

        // Need properties / inline definition support
        foreach ($types as $allowed) {

            // @todo - this is sus
            if (isset($allowed['generic']) && $value instanceof $allowed['generic']) {
                return true;
            }

            // @todo - this is sus
            if (isset($allowed['prototype']) && $value instanceof $allowed['prototype']) {
                return true;
            }

            if (isset($allowed['stream']) && $value->stream()->id == $allowed['stream']) {
                return true;
            }
        }

        return false;
    }
}
