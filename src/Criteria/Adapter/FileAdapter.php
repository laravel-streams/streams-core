<?php

namespace Streams\Core\Criteria\Adapter;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Streams\Core\Stream\Stream;
use Illuminate\Support\Collection;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Config;
use Streams\Core\Entry\Contract\EntryInterface;

class FileAdapter extends AbstractAdapter
{
    protected $data = [];
    protected $query = [];

    public function __construct(Stream $stream)
    {
        $this->stream = $stream;

        $this->readData();

        $this->query = new Collection($this->data);
    }

    public function orderBy($field, $direction = 'asc'): self
    {
        $this->query = $this->query->sortBy($field, SORT_REGULAR, strtolower($direction) === 'desc' ? true : false);

        return $this;
    }

    public function limit($limit, $offset = 0): self
    {
        if ($offset) {
            $this->query = $this->query->skip($offset);
        }

        $this->query = $this->query->take($limit);

        return $this;
    }

    public function where($field, $operator = null, $value = null, $nested = null): self
    {
        if (!$value) {
            $value = $operator;
            $operator = '=';
        }

        $operator = strtoupper($operator);

        $method = $nested ? Str::studly($nested . '_where') : 'where';

        if ($operator == 'LIKE') {
            $this->query = $this->query->filter(function ($entry) use ($field, $value) {
                return Str::is(
                    strtolower(str_replace('%', '*', $value)),
                    strtolower($entry[$field])
                );
            });
        } elseif ($operator == 'IN') {
            $this->query = $this->query->whereIn($field, $value);
        } else {
            $this->query = $this->query->{$method}($field, $operator, $value);
        }

        return $this;
    }

    public function get(array $parameters = []): Collection
    {
        $this->query = $this->collect($this->query);

        $this->callParameterMethods($parameters);

        return $this->query;
    }

    public function count(array $parameters = []):int
    {
        return $this->get($parameters)->count();
    }

    public function save($entry): bool
    {
        $attributes = $entry->getAttributes();

        $keyName = $this->stream->config('key_name', 'id');

        if (!Arr::has($attributes, $keyName)) {
            throw new \Exception('The ID attribute is required.');
        }

        $key = Arr::get($attributes, $keyName);

        $format = $this->stream->config('source.format', 'json') ?: 'json';

        if ($format == 'csv') {

            $fields = $this->stream->fields->keys()->all();

            $fields = array_combine($fields, array_fill(0, count($fields), null));

            $this->data[$key] = array_merge($fields, $attributes);
        }

        if ($format == 'json') {
            $this->data[$key] = $attributes;
        }

        return $this->writeData();
    }

    public function delete(array $parameters = []): bool
    {
        $keyName = $this->stream->config('key_name', 'id');

        $this->get($parameters)->each(function ($entry) use ($keyName) {
            unset($this->data[$entry->{$keyName}]);
        });

        $this->writeData();

        return true;
    }

    public function truncate(): void
    {
        $this->data = [];

        $this->writeData();
    }

    protected function make($entry): EntryInterface
    {
        if ($entry instanceof EntryInterface) {
            return $entry;
        }

        return $this->newInstance($entry);
    }

    protected function readData()
    {
        $format = $this->stream->config('source.format');
        $file = base_path(trim($this->stream->config('source.file', Config::get('streams.core.data_path') . '/' . $this->stream->handle . '.' . ($format ?: 'json')), '/\\'));

        $format = $format ?: pathinfo($file, PATHINFO_EXTENSION);

        if (!file_exists($file)) {

            $this->data = [];

            return;
        }

        $keyName = $this->stream->config('key_name', 'id');
        
        if ($format == 'php') {

            $data = include $file;

            array_walk($data, function ($item, $key) use ($keyName) {

                $key = Arr::get($item, $keyName, $key);

                $this->data[$key] = [$keyName => $key] + $item;
            });
        }

        if ($format == 'json') {

            $data = json_decode(file_get_contents($file), true);

            array_walk($data, function ($item, $key) use ($keyName) {

                $key = Arr::get($item, $keyName, $key);

                $this->data[$key] = [$keyName => $key] + $item;
            });
        }

        if ($format == 'csv') {

            $handle = fopen($file, 'r');

            $i = 0;

            while (($row = fgetcsv($handle)) !== false) {

                if ($i == 0) {
                    $fields = $row;
                    $i++;
                    continue;
                }

                $row = array_combine($fields, $row);

                $key = Arr::get($row, $keyName, $key);
                
                $this->data[$key] = [$keyName => $key] + $row;

                $i++;
            }

            fclose($handle);
        }
    }

    protected function writeData()
    {
        $format = $this->stream->config('source.format', 'json');

        $file = base_path(trim($this->stream->config('source.file', Config::get('streams.core.data_path') . '/' . $this->stream->handle . '.' . ($format ?: 'json')), '/\\'));

        $keyName = $this->stream->config('key_name', 'id');

        $data = [];

        array_walk($this->data, function ($item, $key) use (&$data, $keyName) {
            
            $key = Arr::get($item, $keyName) ?: $key;

            $data[(string) $key] = $item;
        });

        $this->data = $data;

        if (!file_exists($file)) {
            (new Filesystem())->ensureDirectoryExists(dirname($file), 0755, true);
        }

        if ($format == 'php') {
            file_put_contents($file, "<?php\n\nreturn " . Arr::export($this->data, true) . ';');
        }

        if ($format == 'json') {
            file_put_contents($file, json_encode($this->data, JSON_PRETTY_PRINT));
        }

        if ($format == 'csv') {

            $handle = fopen($file, 'w');

            fputcsv($handle, $this->stream->fields->keys()->all());

            array_map(function ($item) use ($handle) {
                fputcsv($handle, $item);
            }, $this->data);

            fclose($handle);
        }

        return true;
    }
}
