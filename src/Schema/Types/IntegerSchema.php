<?php

namespace Streams\Core\Schema\Types;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;

class IntegerSchema extends NumberSchema
{

    public function type(): Schema
    {
        return Schema::integer($this->field->handle);
    }
}
