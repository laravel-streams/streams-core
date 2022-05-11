<?php

namespace Streams\Core\Stream;

use GoldSpecDigital\ObjectOrientedOAS\Objects\ExternalDocs;
use Streams\Core\Field\Field;
use Streams\Core\Stream\Stream;
use Streams\Core\Support\Traits\FiresCallbacks;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Tag;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;

/**
 * This class helps describe streams
 * using the OpenAPI 3.0 specification.
 */
class StreamSchema
{
    use FiresCallbacks;

    protected Stream $stream;

    public function __construct(Stream $stream)
    {
        $this->stream = $stream;
    }

    public function tag(): Tag
    {
        $schema = Tag::create()
            ->name(__($this->stream->name()))
            ->description(__($this->stream->description));
            
        if ($this->stream->docs) {
            $schema = $schema->externalDocs(ExternalDocs::create($this->stream->id)
                ->url($this->stream->docs));
        }

        return $schema;
    }

    public function object(): Schema
    {
        $required = $this->stream->fields
            ->required()
            ->map(fn ($field) => $field->handle)
            ->values()
            ->all();

        $properties = array_filter($this->properties());

        $required = array_keys(array_intersect_key($properties, array_flip($required)));

        // @todo figure out why some property values are null
        return Schema::object($this->stream->id)
            ->properties(...$properties)
            ->required(...$required);
    }

    public function properties(): array
    {
        return $this->stream->fields->map(function (Field  $field) {
            return $field->schema()->property();
        })->all();
    }
}
