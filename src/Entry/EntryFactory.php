<?php

namespace Streams\Core\Entry;

use Streams\Core\Stream\Stream;
use Illuminate\Support\Collection;
use Illuminate\Support\Traits\Macroable;
use Streams\Core\Support\Traits\HasMemory;
use Streams\Core\Entry\Contract\EntryInterface;

/**
 * This class helps with the creation of fake data.
 */
class EntryFactory
{
    use Macroable {
        Macroable::__call as private callMacroable;
    }

    use HasMemory;

    public int $count = 1;

    public function __construct(public Stream $stream)
    {
    }

    public function create(array $attributes = []): EntryInterface
    {
        $this->stream->fields->each(function ($field) use (&$attributes) {
            if (!array_key_exists($field->handle, $attributes) && !$field->config('default')) {
                $attributes[$field->handle] = $field->generate();
            }
        });

        return $this->stream->repository()->newInstance($attributes);
    }

    public function collect($count = 1): Collection
    {
        $items = [];

        $keyName = $this->stream->config('key_name', 'id');

        for ($i = 1; $i <= $count; $i++) {

            $entry = $this->create();

            if (is_numeric($entry->{$keyName})) {
                $entry->{$keyName} = $entry->{$keyName} + ($i - 1);
            }

            $items[$i] = $entry;
        }

        $collection = $this->stream->config('collection', Collection::class);

        return new $collection($items);
    }
}
