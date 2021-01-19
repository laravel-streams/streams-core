<?php

namespace Streams\Core\Criteria\Adapter;

use Filebase\Database;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Streams\Core\Stream\Stream;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Streams\Core\Entry\Contract\EntryInterface;

class FilebaseAdapter extends AbstractAdapter
{

    /**
     * The database query.
     *
     * @var Database
     */
    protected $query;

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
        $format = Config::get('streams.sources.types.filebase.formats.' . $format);
        
        $path = $source->get('path', 'streams/data/' . $stream->handle);

        if ($stream->translatable && App::getLocale() != App::getFallbackLocale()) {
            
            $localization = $stream->translatable[App::getLocale()];

            $path = Arr::get($localization, 'source.path', $path);
        }

        $this->query = new Database([
            'dir' => base_path($path),

            //'backupLocation' => 'path/to/database/backup/dir',
            'format'         => $format,
            'cache'          => $source->get('cache', false),
            'cache_expires'  => $source->get('ttl', 1800),
            'pretty'         => true,
            'safe_filename'  => true,
        ]);
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
        $this->query = $this->query->orderBy($field, $direction);

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
        $this->query = $this->query->limit($limit, $offset);

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

        if ($field == 'id') {
            $field = '__id';
        }

        $method = $nested ? Str::studly($nested . '_where') : 'where';

        if (is_string($value) && $operator == 'LIKE') {
            $value = str_replace('%', '', $value); // Filebase doesn't use "%"
        }

        $this->query = $this->query->{$method}($field, $operator, $value);

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
        foreach ($parameters as $key => $call) {

            $method = Str::camel($key);

            foreach ($call as $parameters) {
                call_user_func_array([$this, $method], $parameters);
            }
        }

        return $this->collect($this->query->resultDocuments());
    }

    /**
     * Count the criteria results.
     * 
     * @param array $parameters
     * @return int
     */
    public function count(array $parameters = [])
    {
        foreach ($parameters as $key => $call) {

            $method = Str::camel($key);

            foreach ($call as $parameters) {
                call_user_func_array([$this, $method], $parameters);
            }
        }
        
        return $this->query->count();
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
     * Delete an entry.
     *
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        return $this->query
            ->get($id)
            ->delete();
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
                'id' => $entry->getId(),
                'created_at' => $entry->createdAt(),
                'updated_at' => $entry->updatedAt(),
            ],
            $entry->toArray()
        ));
    }
}
