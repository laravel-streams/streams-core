<?php

namespace Streams\Core\Field\Value;

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
        return Hash::check($value, $this->value);
    }
}
