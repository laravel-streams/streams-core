<?php

namespace Streams\Core\Field\Type;

use Streams\Core\Field\Type\Str;
use Streams\Core\Field\Value\HashValue;
use Illuminate\Support\Facades\Hash as FacadesHash;

class Hash extends Str
{
    public function modify($value)
    {
        if (is_null($value)) {
            return $value;
        }

        $prefix = $this->config('prefix', '_:');

        if (Str::startsWith($value, $prefix)) {
            throw new \Exception("Value [{$value}] is already hashed.");
        }

        return $prefix . FacadesHash::make($value);
    }

    public function expand($value)
    {
        return new HashValue($value);
    }
}
