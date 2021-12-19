<?php

namespace Streams\Core\Stream;

use Streams\Core\Field\Field;
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
        return Tag::create()
            ->name(__($this->stream->name()))
            ->description(__($this->stream->description));
    }

    public function object(): Schema
    {
        // @todo figure out why some property values are null
        $props=array_filter($this->properties());
        return Schema::object($this->stream->id)
            ->properties(...$props);
    }

    public function properties(): array
    {
        return $this->stream->fields->map(function (Field  $field) {
            return $field->schema();
        })->all();
    }
}
