<?php

namespace Streams\Core\Criteria\Adapter;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Streams\Core\Stream\Stream;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Config;
use Streams\Core\Entry\Contract\EntryInterface;

class DatabaseAdapter extends AbstractAdapter
{
    protected $query;

    public function __construct(Stream $stream)
    {
        $this->stream = $stream;

        if (!$connection = $stream->config('source.connection')) {
            $connection = Config::get('database.default');
        }

        $this->query = DB::connection($connection)
            ->table($stream->config('source.table', $stream->id));
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
        $attributes = $entry->getAttributes();

        $keyName = $this->stream->config('key_name', 'id');

        // @todo Configurable key_name
        if ($id = Arr::pull($attributes, $keyName)) {
            return $this->query->where($keyName, $id)->update($attributes);
        }

        $id = $this->query->insertGetId($entry->getAttributes());

        $entry->{$keyName} = $id;

        return true;
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
        return $this->newInstance((array) $entry);
    }
}
