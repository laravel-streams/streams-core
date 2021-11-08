<?php

namespace Streams\Core\Field\Type;

use Streams\Core\Field\FieldType;
use Streams\Core\Field\Value\EmailValue;

class Email extends FieldType
{
    public function modify($value)
    {
        if (is_null($value)) {
            return $value;
        }

        if (filter_var($value, FILTER_VALIDATE_EMAIL) === false) {
            return null;
        }

        return (string) $value;
    }

    public function restore($value)
    {
        if (is_null($value)) {
            return $value;
        }

        if (filter_var($value, FILTER_VALIDATE_EMAIL) === false) {
            return null;
        }

        return (string) $value;
    }

    public function expand($value)
    {
        return new EmailValue($value);
    }

    public function generate()
    {
        return $this->generator()->email();
    }
}
