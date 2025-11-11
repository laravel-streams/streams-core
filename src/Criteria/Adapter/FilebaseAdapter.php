<?php

namespace Streams\Core\Criteria\Adapter;

use Filebase\Database;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Streams\Core\Stream\Stream;
use Illuminate\Support\Facades\Config;

class FilebaseAdapter extends AbstractAdapter
{
    protected $query;

    public function __construct(Stream $stream)
    {
        $this->stream = $stream;

        $this->query = $this->newQuery();
    }

    public function newQuery()
    {
        $format = $this->stream->config('source.format', 'json');

        $format = Config::get('streams.core.sources.filebase.formats.' . $format);

        $path = ltrim($this->stream->config('source.path', Config::get('streams.core.data_path') . '/' . $this->stream->id), '/\\');

        return new Database([
            'pretty' => true,
            'format' => $format,
            'safe_filename' => true,
            'dir' => base_path($path),
            'cache' => $this->stream->config('cache', false),
            'cache_expires' => $this->stream->config('ttl', 1800),
        ]);
    }

    public function orderBy($field, $direction = 'asc'): static
    {
        if ($field == 'id') {
            $field = '__id';
        }

        $this->query = $this->query->orderBy($field, $direction);

        return $this;
    }

    public function limit($limit, $offset = 0): static
    {
        $this->query = $this->query->limit($limit, $offset);

        return $this;
    }

    public function where($field, $operator = null, $value = null, $nested = null): static
    {
        if (is_null($value)) {
            $value = $operator;
            $operator = '=';
        }

        $operator = strtoupper($operator);

        if ($operator == '<>') {
            $operator = '!=';
        }

        if ($field == 'id') {
            $field = '__id';
        }

        $method = $nested ? Str::studly($nested . '_where') : 'where';

        if (is_string($value) && $operator == 'LIKE') {
            $value = str_replace('%', '', str_replace('/', '\/', $value)); // Filebase doesn't use "%"
        }

        $this->query = $this->query->{$method}($field, $operator, $value);

        return $this;
    }

    public function get(array $parameters = []): array
    {
        $this->callParameterMethods($parameters);

        return $this->query->resultDocuments();
    }

    public function count(array $parameters = []): int
    {
        $this->callParameterMethods($parameters);

        return $this->query->count();
    }

    public function save(array $attributes): array
    {
        $keyName = $this->stream->config('key_name', 'id');

        /**
         * Remove these protected
         * and automated attributes.
         */
        // Arr::pull($attributes, 'id');
        Arr::pull($attributes, 'stream');
        Arr::pull($attributes, 'created_at');
        Arr::pull($attributes, 'updated_at');

        $this->newQuery()->get($attributes[$keyName])->save($attributes);

        return $attributes;
    }

    public function delete(array $parameters = []): bool
    {
        $this->callParameterMethods($parameters);

        $this->query->delete();

        return true;
    }

    public function truncate(): void
    {
        $this->query->truncate();
    }
}
