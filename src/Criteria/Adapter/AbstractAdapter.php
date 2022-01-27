<?php

namespace Streams\Core\Criteria\Adapter;

use Filebase\Database;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Streams\Core\Entry\Entry;
use Streams\Core\Stream\Stream;
use Illuminate\Support\Collection;
use Illuminate\Support\Traits\Macroable;
use Streams\Core\Support\Traits\HasMemory;
use Streams\Core\Entry\Contract\EntryInterface;
use Streams\Core\Criteria\Contract\AdapterInterface;

/**
 * Adapters act as drivers to satisfy the
 * query building needs of the higher criteria.
 */
abstract class AbstractAdapter implements AdapterInterface
{

    use Macroable;
    use HasMemory;

    protected $query;

    protected Stream $stream;

    abstract public function orderBy($field, $direction = 'asc'): self;

    abstract public function limit($limit, $offset = 0): self;

    abstract public function where($field, $operator = null, $value = null, $nested = null): self;

    public function orWhere($field, $operator = null, $value = null): self
    {
        return $this->where($field, $operator, $value, 'or');
    }

    abstract public function get(array $parameters = []): Collection;

    abstract public function count(array $parameters = []): int;

    abstract public function delete(array $parameters = []): bool;

    abstract public function save(EntryInterface $entry): bool;

    abstract public function truncate(): void;

    protected function collect($entries): Collection
    {
        if ($entries instanceof Collection) {
            $entries = $entries->all();
        }

        $collection = $this->stream
            ->repository()
            ->newCollection();

        array_map(function ($entry) use ($collection) {
            $entry = $this->make($entry);
            // @todo this is where all entries get stream info.
            // Maybe we do like __stream to prevent collision 
            //$entry->stream = $this->stream;
            $collection->push($entry);
        }, $entries);

        return $collection;
    }

    public function newInstance(array $attributes = []): EntryInterface
    {
        $prototype = $this->stream->config('abstract', Entry::class);

        unset($attributes['__created_at']);
        unset($attributes['__updated_at']);

        $prototype = new $prototype([
            'stream' => $this->stream,
        ]);

        $prototype->setPrototypeProperties($this->stream->fields->toArray());

        $this->fillDefaults($attributes);

        $prototype->setPrototypeAttributes($attributes);

        return $prototype;
    }

    /**
     * Return an entry interface from data.
     *
     * @param $entry
     * @return EntryInterface
     */
    protected function make($entry)
    {
        $data = Arr::undot($entry->toArray());

        unset($data['__created_at']);
        unset($data['__updated_at']);

        $keyName = $this->stream->config('key_name', 'id');

        $data = array_merge([$keyName => $entry->getId()], $data);

        $entry = $this->newInstance()->setRawPrototypeAttributes($data);

        return $entry;
    }

    protected function callParameterMethods(array $parameters): void
    {
        foreach ($parameters as $key => $call) {

            $method = Str::camel($key);

            foreach ($call as $parameters) {
                call_user_func_array([$this, $method], $parameters);
            }
        }
    }

    protected function fillDefaults(array &$attributes): void
    {
        foreach ($this->stream->fields as $field) {

            if (!$default = $field->config('default')) {
                continue;
            }

            if (array_key_exists($field->handle, $attributes)) {
                continue;
            }

            $attributes[$field->handle] = $field->default($default);
        }
    }
}
