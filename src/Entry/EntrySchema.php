<?php

namespace Streams\Core\Entry;

use Illuminate\Support\Str;
use Streams\Core\Stream\Stream;
use Streams\Core\Support\Traits\FiresCallbacks;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Tag;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;

/**
 * This class helps with the schema declaration.
 */
class EntrySchema
{

    use FiresCallbacks;

    protected Stream $stream;

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

    public function object()
    {
        return Schema::object($this->stream->id)
            ->properties(...$this->properties());
    }

    public function properties()
    {
        return $this->stream->fields->map(function ($field) {
            return $field->schema();
        })->all();
    }
}
