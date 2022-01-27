<?php

namespace Streams\Core\Criteria\Adapter;

use Illuminate\Support\Str;
use Streams\Core\Stream\Stream;
use Illuminate\Support\Collection;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Model;
use Streams\Core\Entry\Contract\EntryInterface;

class EloquentAdapter extends AbstractAdapter
{

    protected $query;

    public function __construct(Stream $stream)
    {
        $this->stream = $stream;

        $model = $stream->config('source.model');

        $stream->config('abstract', $model);

        $this->query = (new $model)->newQuery();
    }

    public function orderBy($field, $direction = 'asc'): self
    {
        $this->query = $this->query->orderBy($field, $direction);

        return $this;
    }

    public function limit($limit, $offset = 0): self
    {
        $this->query = $this->query->take($limit)->skip($offset);

        return $this;
    }

    public function where($field, $operator = null, $value = null, $nested = null): self
    {
        if (!$value) {
            $value = $operator;
            $operator = '=';
        }

        $method = Str::studly($nested ? $nested . '_where' : 'where');

        $this->query = $this->query->{$method}($field, $operator, $value);

        return $this;
    }

    public function withTrashed($toggle): self
    {
        if ($toggle) {
            $this->query = $this->query->withTrashed();
        }

        return $this;
    }

    public function with($relations): self
    {
        $this->query = $this->query->with($relations);

        return $this;
    }

    public function get(array $parameters = []): Collection
    {
        $this->callParameterMethods($parameters);

        return $this->collect($this->query->get());
    }

    public function count(array $parameters = []): int
    {
        $this->callParameterMethods($parameters);

        return $this->query->count();
    }

    public function save($entry): bool
    {
        return $entry->save();
    }

    public function delete(array $parameters = []): bool
    {
        $this->callParameterMethods($parameters);
        
        return $this->query->delete();
    }

    public function truncate(): void
    {
        $this->query->truncate();
    }

    protected function make($entry): EntryInterface
    {
        return $entry;
    }

    public function newInstance(array $attributes = []): EntryInterface
    {
        $model = $this->stream->config('source.model');

        $model = new $model($attributes);

        return $model;
    }
}
