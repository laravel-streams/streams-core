<?php

namespace Streams\Core\Schema\Types;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;

class DecimalSchema extends NumberSchema
{

    public function type(): Schema
    {
        return Schema::number($this->field->handle)->format(Schema::FORMAT_FLOAT);
    }
}
