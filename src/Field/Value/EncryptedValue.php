<?php

namespace Streams\Core\Field\Value;

use Illuminate\Support\Facades\Crypt;

class EncryptedValue extends Value
{

    /**
     * Compare a value to
     * the hashed value.
     *
     * @return string
     */
    public function decrypt()
    {
        return Crypt::decrypt($this->value);
    }
}
