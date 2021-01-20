<?php

namespace Streams\Core\Criteria\Adapter;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Streams\Core\Stream\Stream;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Streams\Core\Entry\Contract\EntryInterface;

class FileAdapter extends AbstractAdapter
{

    /**
     * Create a new class instance.
     *
     * @param Stream $stream
     */
    public function __construct(Stream $stream)
    {
        $this->stream = $stream;

        $source = $stream->expandPrototypeAttribute('source');

        $format = $source->get('format', 'json');
        $path = trim($source->get('path', 'streams/data'), '/\\');

        if ($format == 'json') {

            $this->data = json_decode(file_get_contents(base_path($path . '/' . $stream->handle . '.' . $format)), true);

            array_walk($this->data, function ($item, $key) {
                $this->data[$key] = ['id' => $key] + $item;
            });
        }

        if ($format == 'csv') {

            $handle = fopen(base_path($path . '/' . $stream->handle . '.' . $format), 'r');

            $i = 0;

            while (($row = fgetcsv($handle, 4096)) !== false) {

                if (empty($fields)) {
                    $fields = $row;
                    continue;
                }

                foreach ($row as $k => $value) {
                    $this->data[$i][$fields[$k]] = $value;
                }

                $i++;
            }

            fclose($handle);
        }
    }

    /**
     * Order the query by field/direction.
     *
     * @param string $field
     * @param string|null $direction
     * @param string|null $value
     */
    public function orderBy($field, $direction = 'asc')
    {
        $this->data = $this->data->sortBy($field, strtolower($direction) == 'asc' ? 0 : 1);

        return $this;
    }

    /**
     * Limit the entries returned.
     *
     * @param int $limit
     * @param int|null $offset
     */
    public function limit($limit, $offset = 0)
    {
        if ($offset) {
            $this->data = $this->data->skip($offset);
        }

        $this->data = $this->data->take($limit);

        return $this;
    }

    /**
     * Constrain the query by a typical 
     * field, operator, value argument.
     *
     * @param string $field
     * @param string|null $operator
     * @param string|null $value
     * @param string|null $nested
     */
    public function where($field, $operator = null, $value = null, $nested = null)
    {
        if (!$value) {
            $value = $operator;
            $operator = '=';
        }

        $operator = strtoupper($operator);

        if ($field == 'handle') {
            $field = $this->stream->getPrototypeAttribute('config.handle', 'id');
        }

        $method = $nested ? Str::studly($nested . '_where') : 'where';

        if (is_string($value) && $operator == 'LIKE') {
            $value = str_replace('%', '', $value); // Filebase doesn't use "%"
        }

        $this->data = $this->data->{$method}($field, $operator, $value);

        return $this;
    }

    /**
     * Get the criteria results.
     * 
     * @param array $parameters
     * @return Collection
     */
    public function get(array $parameters = [])
    {
        $this->data = $this->collect($this->data);

        foreach ($parameters as $key => $call) {

            $method = Str::camel($key);

            foreach ($call as $parameters) {
                call_user_func_array([$this, $method], $parameters);
            }
        }

        return $this->data;
    }

    /**
     * Count the criteria results.
     * 
     * @param array $parameters
     * @return int
     */
    public function count(array $parameters = [])
    {
        return $this->get($parameters)->count();
    }

    /**
     * Create a new entry.
     *
     * @param array $attributes
     * @return EntryInterface
     */
    public function create(array $attributes = [])
    {
        $id = Arr::pull($attributes, 'id');

        if ($this->query->has($id)) {
            throw new \Exception("Entry with ID [{$id}] already exists.");
        }

        $document = $this->query->get($id);

        if (!$document->save($attributes)) {
            return false;
        }

        return $this->make($document);
    }

    /**
     * Save an entry.
     *
     * @param  EntryInterface $entry
     * @return bool
     */
    public function save($entry)
    {
        $attributes = $entry->getAttributes();

        /**
         * Remove these protected
         * and automated attributes.
         */
        Arr::pull($attributes, 'id');
        Arr::pull($attributes, 'created_at');
        Arr::pull($attributes, 'updated_at');

        return (bool) $this->query
            ->get($entry->id)
            ->save($attributes);
    }

    /**
     * Delete results.
     *
     * @param array $parameters
     * @return bool
     */
    public function delete(array $parameters = [])
    {
        foreach ($parameters as $key => $call) {

            $method = Str::camel($key);

            foreach ($call as $parameters) {
                call_user_func_array([$this, $method], $parameters);
            }
        }
        
        return $this->query->delete();
    }

    /**
     * Truncate all entries.
     *
     * @return void
     */
    public function truncate()
    {
        $this->query->truncate();
    }

    /**
     * Return an entry interface from a file.
     *
     * @param $entry
     * @return EntryInterface
     */
    protected function make($entry)
    {
        return $this->newInstance(array_merge(
            [
                //'id' => Arr::get($entry, 'id'),
                //'created_at' => Arr::get($entry, 'created_at'),
                //'updated_at' => Arr::get($entry, 'updated_at'),
            ],
            $entry
        ));
    }
}
