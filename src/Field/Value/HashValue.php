<?php

namespace Streams\Core\Field\Value;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class HashValue extends Value
{

    /**
     * Compare a value to
     * the hashed value.
     *
     * @param $value
     */
    public function check($value)
    {
        $prefix = '_:';
    
        if (!Str::startsWith($this->value, $prefix)) {
            return false;
        }
            
        return Hash::check($value, substr($this->value, strlen($prefix)));
    }
}
