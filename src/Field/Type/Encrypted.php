<?php

namespace Streams\Core\Field\Type;

use Illuminate\Support\Facades\Crypt;
use Streams\Core\Field\Value\EncryptedValue;
use Streams\Core\Field\Factory\EncryptedGenerator;

class Encrypted extends Str
{

    /**
     * Modify the value for storage.
     *
     * @param string $value
     * @return string
     */
    public function modify($value)
    {
        if (is_null($value)) {
            return $value;
        }
        
        return Crypt::encrypt($value);
    }

    /**
     * Expand the value.
     *
     * @param $value
     * @return Collection
     */
    public function expand($value)
    {
        return new EncryptedValue($value);
    }

    public function generator(): EncryptedGenerator
    {
        return new EncryptedGenerator($this);
    }
}
