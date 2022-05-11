<?php

namespace Streams\Core\Schema\Types;

use Streams\Core\Field\FieldSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;

class BooleanSchema extends FieldSchema
{

    public function type(): Schema
    {
        return Schema::boolean($this->field->handle);
    }
}
