<?php

namespace Streams\Core\Field\Type;

use Streams\Core\Field\FieldType;
use Illuminate\Support\Facades\Crypt;
use Streams\Core\Field\Value\EncryptedValue;

class Encrypted extends FieldType
{

    public function modify($value)
    {
        if (is_null($value)) {
            return $value;
        }
        
        return Crypt::encrypt($value);
    }

    public function expand($value)
    {
        return new EncryptedValue($value);
    }

    public function generate()
    {
        return Crypt::encrypt($this->generator()->text(15, 50));
    }
}
