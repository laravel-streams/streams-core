<?php

namespace Streams\Core\Field\Schema;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;

class DecimalSchema extends NumberSchema
{

    public function type(): Schema
    {
        return Schema::number($this->type->field->handle)->format(Schema::FORMAT_FLOAT);
    }
}
