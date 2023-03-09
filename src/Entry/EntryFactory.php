<?php

namespace Streams\Core\Entry;

use Streams\Core\Stream\Stream;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Traits\Macroable;
use Streams\Core\Support\Traits\HasMemory;
use Streams\Core\Entry\Contract\EntryInterface;
use Streams\Core\Support\Traits\FiresCallbacks;

class EntryFactory
{
    use HasMemory;
    use FiresCallbacks;
    
    use Macroable {
        Macroable::__call as private callMacroable;
    }

    protected $attributes = [];

    public function __construct(public Stream $stream)
    {
    }

    public function create(array $attributes = []): EntryInterface
    {
        $attributes = collect(array_merge($this->attributes, $attributes));

        $this->fire('creating', compact('attributes'));

        $this->stream->fields->each(function ($field) use (&$attributes) {
            if (!$attributes->has($field->handle) && !$field->config('default')) {
                $attributes[$field->handle] = $field->generate();
            }
        });

        $instance = $this->stream->repository()->newInstance($attributes->all());

        $this->fire('created', compact('instance'));

        return $instance;
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

    protected function state($callback)
    {
        if (is_array($callback)) {
            
            $this->attributes = array_merge($this->attributes, $callback);

            return $this;
        }

        if (is_callable($callback)) {

            $this->attributes = array_merge($this->attributes, $callback($this->attributes));

            return $this;
        }

        $this->attributes = array_merge($this->attributes, App::call($callback, ['attributes' => $this->attributes]));

        return $this;
    }
}
