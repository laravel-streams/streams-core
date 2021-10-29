<?php

namespace Streams\Core\Field\Type;

use Streams\Core\Field\Type\Str;
use Streams\Core\Field\Value\HashValue;
use Streams\Core\Field\Factory\HashGenerator;
use Illuminate\Support\Facades\Hash as FacadesHash;

class Hash extends Str
{
    public function modify($value)
    {
        if (is_null($value)) {
            return $value;
        }

        return FacadesHash::make($value);
    }

    public function expand($value)
    {
        return new HashValue($value);
    }

    public function generator(): HashGenerator
    {
        return new HashGenerator($this);
    }
}
