<?php

namespace Streams\Core\Schema\Types;

use Streams\Core\Field\FieldSchema;
use Streams\Core\Support\Facades\Streams;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;

class PrototypeSchema extends FieldSchema
{
    public function type(): Schema
    {
        $stream = Streams::build([
            'fields' => $this->field->config('properties', []),
        ]);

        return Schema::object($this->field->handle)
            ->properties(...$stream->schema()->properties());
    }
}
