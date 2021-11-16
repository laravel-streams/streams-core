<?php

namespace Streams\Core\Field\Type;

use Streams\Core\Field\FieldType;
use Streams\Core\Field\Value\HashValue;
use Illuminate\Support\Facades\Hash as HashFacade;

class Hash extends FieldType
{
    public function modify($value)
    {
        if (is_null($value)) {
            return $value;
        }

        if (strpos($value, '$2y$') === 0 && strlen($value) == 60) {
            return $value;
        }

        return HashFacade::make($value);
    }

    public function expand($value)
    {
        return new HashValue($value);
    }

    public function generate()
    {
        return HashFacade::make($this->generator()->text(15, 50));
    }
}
