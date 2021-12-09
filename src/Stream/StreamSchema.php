<?php

namespace Streams\Core\Stream;

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
        return Schema::object($this->stream->id)
            ->properties(...$this->properties());
    }

    public function properties(): array
    {
        return $this->stream->fields->map(function ($field) {
            return $field->schema();
        })->all();
    }
}
