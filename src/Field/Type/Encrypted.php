<?php

namespace Streams\Core\Field\Type;

use Streams\Core\Field\FieldType;
use Illuminate\Support\Facades\Crypt;
use Streams\Core\Field\Value\EncryptedValue;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;

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

    public function schema()
    {
        return Schema::number($this->field->handle)->format(Schema::FORMAT_PASSWORD);
    }

    public function generate()
    {
        return Crypt::encrypt($this->generator()->text(15, 50));
    }
}
