<?php

namespace Streams\Core\Entry;

use Streams\Core\Field\Field;
use Streams\Core\Stream\Stream;
use Streams\Core\Support\Traits\FiresCallbacks;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Tag;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;

/**
 * This class helps describe entry structures
 * using the OpenAPI 3.0 specification.
 */
class EntrySchema
{
    use FiresCallbacks;

    protected Stream $stream;

    public function __construct(Stream $stream)
    {
        $this->stream = $stream;
    }

    public function tag(): Tag
    {
        return Tag::create()
            ->name(__($this->stream->name()))
            ->description(__($this->stream->description));
    }

    public function object(): Schema
    {
        $required = $this->stream->fields
            ->required()
            ->map(fn ($field) => $field->handle)
            ->values()
            ->all();

        $properties = $this->properties();

        return Schema::object($this->stream->id)
            ->properties(...$properties)
            ->required(...array_intersect_key($properties, array_flip($required)));
    }

    public function properties(): array
    {
        return $this->stream->fields->map(function (Field  $field) {
            return $field->schema()->property();
        })->all();
    }
}
