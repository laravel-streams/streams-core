<?php

namespace Streams\Core\Field\Types;

use Streams\Core\Field\Field;
use Illuminate\Support\Facades\Crypt;
use Streams\Core\Field\Schema\EncryptedSchema;
use Streams\Core\Field\Decorator\EncryptedDecorator;

class EncryptedFieldType extends Field
{
    public function cast($value)
    {
        return Crypt::encrypt($value);
    }

    public function getSchemaName()
    {
        return EncryptedSchema::class;
    }

    public function getDecoratorName()
    {
        return EncryptedDecorator::class;
    }

    // public function generate()
    // {
    //     return Crypt::encrypt($this->generator()->text(15, 50));
    // }
}
