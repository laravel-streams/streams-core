<?php

namespace Streams\Core\Field\Schema;

use Streams\Core\Field\FieldSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;

class BooleanSchema extends FieldSchema
{
    public function type(): Schema
    {
        return Schema::boolean($this->field->handle);
    }
}
