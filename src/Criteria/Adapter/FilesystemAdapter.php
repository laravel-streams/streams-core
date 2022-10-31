<?php

namespace Streams\Core\Criteria\Adapter;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Streams\Core\Stream\Stream;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Filesystem\Filesystem;

class FilesystemAdapter extends AbstractAdapter
{
    protected Filesystem $disk;

    public function __construct(Stream $stream)
    {
        $this->stream = $stream;

        $this->disk = Storage::disk($stream->config('source.disk', 'local'));
    }

    public function orderBy($field, $direction = 'asc'): static
    {
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
        if (!$value) {
            $value = $operator;
            $operator = '=';
        }

        $operator = strtoupper($operator);

        $method = $nested ? Str::studly($nested . '_where') : 'where';

        $this->query = $this->query->{$method}($field, $operator, $value);

        return $this;
    }

    public function get(array $parameters = []): Collection
    {
        $this->query = $this->collect($this->disk->allFiles());

        $this->callParameterMethods($parameters);

        return $this->query;
    }

    public function count(array $parameters = []): int
    {
        $this->query = $this->collect($this->disk->allFiles());

        $this->callParameterMethods($parameters);

        return $this->query->count();
    }

    public function save($entry): bool
    {
        $attributes = $entry->getAttributes();

        $keyName = $this->stream->config('key_name', 'id');

        /**
         * Remove these protected
         * and automated attributes.
         */
        Arr::pull($attributes, 'id');
        Arr::pull($attributes, 'stream');
        Arr::pull($attributes, 'created_at');
        Arr::pull($attributes, 'updated_at');

        return (bool) $this->query
            ->get($entry->{$keyName})
            ->save($attributes);
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

    protected function make($entry)
    {
        return ['name' => $entry];
    }
}
