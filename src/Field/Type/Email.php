<?php

namespace Streams\Core\Field\Type;

use Streams\Core\Field\Field;
use Streams\Core\Field\Value\EmailValue;
use Streams\Core\Field\Schema\EmailSchema;

class Email extends Field
{
    public function modify($value)
    {
        return $this->cast($value);
    }

    public function cast($value)
    {
        if (filter_var($value, FILTER_VALIDATE_EMAIL) === false) {
            return null;
        }

        return (string) $value;
    }

    public function getValueName()
    {
        return EmailValue::class;
    }

    public function getSchemaName()
    {
        return EmailSchema::class;
    }

    public function generate()
    {
        return $this->generator()->email();
    }
}
