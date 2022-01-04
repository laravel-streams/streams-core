<?php

namespace Streams\Core\Field\Type;

use Streams\Core\Field\FieldType;
use Illuminate\Support\Facades\Crypt;
use Streams\Core\Field\Value\EncryptedValue;
use Streams\Core\Field\Schema\EncryptedSchema;

class Encrypted extends FieldType
{
    
    public function modify($value)
    {
        return Crypt::encrypt($value);
    }

    public function getValueName()
    {
        return EncryptedValue::class;
    }

    public function getSchemaName()
    {
        return EncryptedSchema::class;
    }

    public function generate()
    {
        return Crypt::encrypt($this->generator()->text(15, 50));
    }
}
