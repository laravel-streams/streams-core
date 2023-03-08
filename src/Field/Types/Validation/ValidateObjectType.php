<?php

namespace Streams\Core\Field\Types\Validation;

use Streams\Core\Field\Field;
use Streams\Core\Entry\Contract\EntryInterface;
use Illuminate\Contracts\Validation\InvokableRule;

class ValidateObjectType implements InvokableRule
{
    public function __construct(protected Field $field)
    {
    }

    public function __invoke($attribute, $value, $fail)
    {
        if (is_null($value)) {
            return;
        }

        if (!is_object($value)) {
            $fail('The :attribute must be an object.');
        }

        if (!$types = $this->field->config('allowed')) {
            return;
        }

        // Need properties / inline definition support
        foreach ($types as $allowed) {

            // @todo - this is sus
            if (isset($allowed['generic']) && $value instanceof $allowed['generic']) {
                return;
            }

            // @todo - this is sus
            if (isset($allowed['prototype']) && $value instanceof $allowed['prototype']) {
                return;
            }

            if (isset($allowed['stream']) && $value instanceof EntryInterface && $value->stream()->id == $allowed['stream']) {
                return;
            }
        }

        return $fail('The :attribute is not a valid object type.');
    }
}
