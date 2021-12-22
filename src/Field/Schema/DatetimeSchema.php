<?php

namespace Streams\Core\Field\Schema;

use Streams\Core\Field\FieldSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;

class DatetimeSchema extends FieldSchema
{
    public function type(): Schema
    {
        return Schema::string($this->type->field->handle)->format(Schema::FORMAT_DATE_TIME);
    }
}
