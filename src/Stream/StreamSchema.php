<?php

namespace Streams\Core\Stream;

use Illuminate\Support\Str;
use GoldSpecDigital\ObjectOrientedOAS\OpenApi;
use Streams\Core\Support\Traits\FiresCallbacks;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Tag;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Info;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;

class StreamSchema
{
    use FiresCallbacks;

    public function __construct(Stream $stream)
    {
        $this->stream = $stream;
    }

    public function tag()
    {
        return Tag::create()
            ->name(__($this->stream->name) ?: Str::humanize($this->stream->id))
            ->description(__($this->stream->description));
    }

    public function schema()
    {
        return Schema::object()
            ->properties(...$this->properties());
    }

    public function properties()
    {
        return $this->stream->fields->map(function ($field) {
            return $field->schema();
        })->all();
    }
}
