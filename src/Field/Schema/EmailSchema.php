<?php

namespace Streams\Core\Field\Schema;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;

class EmailSchema extends StrSchema
{
    public function type(): Schema
    {
        return Schema::string($this->field->handle)->format('email');
    }
}
