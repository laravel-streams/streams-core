<?php

namespace Streams\Core\Repository;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Streams\Core\Stream\Stream;
use Illuminate\Support\Collection;
use Streams\Core\Criteria\Criteria;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Traits\Macroable;
use Streams\Core\Support\Traits\HasMemory;
use Streams\Core\Criteria\Adapter\FileAdapter;
use Streams\Core\Criteria\Adapter\SelfAdapter;
use Streams\Core\Entry\Contract\EntryInterface;
use Streams\Core\Support\Traits\FiresCallbacks;
use Streams\Core\Criteria\Adapter\DatabaseAdapter;
use Streams\Core\Criteria\Adapter\EloquentAdapter;
use Streams\Core\Criteria\Adapter\FilebaseAdapter;
use Streams\Core\Repository\Contract\RepositoryInterface;

class Repository implements RepositoryInterface
{

    use Macroable;
    use HasMemory;
    use FiresCallbacks;

    protected Stream $stream;

    public function __construct(Stream $stream)
    {
        $this->stream = $stream;
    }

    public function all(): Collection
    {
        return $this
            ->newCriteria()
            ->get();
    }

    /**
     * @param integer|string $id
     * @return null|EntryInterface
     */
    public function find($id)
    {
        return $this
            ->newCriteria()
            ->find($id);
    }

    public function findAll(array $ids): Collection
    {
        return $this
            ->newCriteria()
            ->where('id', 'IN', $ids)
            ->get();
    }

    /**
     * @param string $field
     * @param mixed $value
     * @return EntryInterface|null
     */
    public function findBy(string $field, $value)
    {
        return $this
            ->newCriteria()
            ->where($field, $value)
            ->first();
    }

    /**
     * @param string $field
     * @param mixed $operator
     * @param mixed $value
     * @return Collection
     */
    public function findAllWhere(string $field, $operator, $value = null): Collection
    {
        return $this
            ->newCriteria()
            ->where($field, $operator, $value)
            ->get();
    }

    public function create(array $attributes): EntryInterface
    {
        $this->fire($this->stream->handle . '.creating', [
            'attributes' => $attributes,
        ]);

        $result =  $this
            ->newCriteria()
            ->create($attributes); // @todo Should instantiate and use save?

        $this->fire($this->stream->handle . '.created', [
            'entry' => $result,
        ]);

        return $result;
    }

    public function save(EntryInterface $entry): bool
    {
        $this->fire($this->stream->handle . '.saving', [
            'entry' => $entry,
        ]);

        $result = $this
            ->newCriteria()
            ->save($entry);

        $this->fire($this->stream->handle . '.saved', [
            'entry' => $entry,
        ]);

        return (bool) $result;
    }

    public function delete(EntryInterface $entry): bool
    {
        $this->fire($this->stream->handle . '.deleting', [
            'entry' => $entry,
        ]);

        $id = is_object($entry) ? $entry->id : $entry;

        $result = $this
            ->newCriteria()
            ->where('id', $id)
            ->delete();

        $this->fire($this->stream->handle . '.deleted', [
            'entry' => $entry,
        ]);

        return (bool) $result;
    }

    public function truncate(): bool
    {
        $this->fire($this->stream->handle . '.truncating');

        $result = $this
            ->newCriteria()
            ->truncate();

        $this->fire($this->stream->handle . '.truncated');

        return (bool) $result;
    }

    public function newInstance(array $attributes = []): EntryInterface
    {
        return $this
            ->newCriteria()
            ->newInstance($attributes);
    }

    public function newCriteria(): Criteria
    {
        $default = Config::get('streams.core.default_source', 'filebase');

        $criteria = $this->stream->config('criteria') ?: Criteria::class;

        if ($adapter = $this->stream->config('source.adapter')) {
            $adapter = new $adapter($this->stream);
        }

        if (!$adapter) {

            $adapter = $this->stream->config('source.type', $default);

            $adapter = Str::camel("new_{$adapter}_adapter");

            $adapter = $this->$adapter();
        }

        return new $criteria($this->stream, $adapter);
    }

    public function newCollection(array $entries = []): Collection
    {
        $collection = Arr::get($this->stream->getPrototypeAttribute('config', []), 'collection', Collection::class);

        return new $collection($entries);
    }

    public function newSelfAdapter(): SelfAdapter
    {
        return new SelfAdapter($this->stream);
    }

    public function newFileAdapter(): FileAdapter
    {
        return new FileAdapter($this->stream);
    }

    public function newFilebaseAdapter(): FilebaseAdapter
    {
        return new FilebaseAdapter($this->stream);
    }

    public function newDatabaseAdapter(): DatabaseAdapter
    {
        return new DatabaseAdapter($this->stream);
    }

    public function newEloquentAdapter(): EloquentAdapter
    {
        return new EloquentAdapter($this->stream);
    }
}
