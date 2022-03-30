<?php

namespace Streams\Core\Repository\Contract;

use Illuminate\Support\Collection;
use Streams\Core\Entry\Contract\EntryInterface;
use Streams\Core\Criteria\Contract\CriteriaInterface;

interface RepositoryInterface
{

    public function all(): Collection;

    public function find(string|int $id);

    public function findAll(array $ids): Collection;

    public function findBy(string $field, $value): EntryInterface|null;

    public function findAllWhere(string $field, $operator, $value = null): Collection;

    public function count(): int;

    /**
     * Find a trashed entry by it's ID.
     *
     * @param $id
     * @return null|EntryInterface
     */
    //public function findTrashed($id);

    public function create(array $attributes): EntryInterface;

    public function save(EntryInterface $entry): bool;

    public function delete(EntryInterface $entry): bool;

    /**
     * Force delete an entry.
     *
     * @param  EntryInterface $entry
     * @return bool
     */
    //public function forceDelete(EntryInterface $entry);

    /**
     * Restore a trashed entry.
     *
     * @param  EntryInterface $entry
     * @return bool
     */
    //public function restore(EntryInterface $entry);

    public function truncate(): void;

    /**
     * Return a new instance.
     *
     * @param array $attributes
     * @return EntryInterface
     */
    public function newInstance(array $attributes = []);

    /**
     * Return a new entry criteria.
     *
     * @return CriteriaInterface
     */
    public function newCriteria();

    /**
     * Return a paginated collection.
     *
     * @param  array $parameters
     * @return LengthAwarePaginator
     */
    //public function paginate(array $parameters = []);

    /**
     * Return the last modified entry.
     *
     * @return EntryInterface|null
     */
    //public function lastModified();

    /**
     * Cache a value in the
     * model's cache collection.
     *
     * @param $key
     * @param $ttl
     * @param null $value
     * @return mixed
     */
    ////public function cache($key, $ttl, $value = null);

    /**
     * Cache (forever) a value in
     * the model's cache collection.
     *
     * @param $key
     * @param $value
     * @return mixed
     */
    ////public function cacheForever($key, $value);
}
