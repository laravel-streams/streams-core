<?php

namespace Streams\Core\Field\Schema;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;

class EncryptedSchema extends StrSchema
{
    public function type(): Schema
    {
        return Schema::string($this->field->handle)->format(Schema::FORMAT_PASSWORD);
    }
}
