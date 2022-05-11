<?php

namespace Streams\Core\Field\Schema;

use Streams\Core\Field\FieldSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;

class SelectSchema extends FieldSchema
{

    public function type(): Schema
    {
        return Schema::string($this->field->handle)
            ->enum(...array_keys($this->field->options()));
    }
}
