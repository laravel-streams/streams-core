<?php

namespace Streams\Core\Field\Schema;

use Streams\Core\Field\FieldSchema;
use Streams\Core\Support\Facades\Streams;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;

class EntrySchema extends FieldSchema
{
    public function type(): Schema
    {
        return Streams::schema(
            $this->field->config('stream')
        )->object()->objectId($this->field->handle);
    }
}
