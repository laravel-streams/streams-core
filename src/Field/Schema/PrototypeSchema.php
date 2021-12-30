<?php

namespace Streams\Core\Field\Schema;

use Streams\Core\Field\FieldSchema;
use Streams\Core\Support\Facades\Streams;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;

class PrototypeSchema extends FieldSchema
{
    public function type(): Schema
    {
        $stream = Streams::build([
            'fields' => $this->type->field->config('properties', []),
        ]);

        return Schema::object($this->type->field->handle)
            ->properties(...$stream->schema()->properties());
    }
}
