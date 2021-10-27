<?php

namespace Streams\Core\Repository\Contract;

use Illuminate\Support\Collection;
use Streams\Core\Entry\Contract\EntryInterface;
use Streams\Core\Criteria\Contract\CriteriaInterface;

interface RepositoryInterface
{

    public function all(): Collection;

    /**
     * @param integer|string $id
     * @return null|EntryInterface
     */
    public function find($id);

    /**
     * @param  array $ids
     * @return Collection
     */
    public function findAll(array $ids): Collection;

    /**
     * @param string $field
     * @param mixed $value
     * @return EntryInterface|null
     */
    public function findBy(string $field, $value);

    /**
     * Find all entries by field value.
     *
     * @param string $field
     * @param mixed $operator
     * @param mixed $value
     * @return Collection
     */
    public function findAllWhere(string $field, $operator, $value = null): Collection;

    /**
     * Find a trashed entry by it's ID.
     *
     * @param $id
     * @return null|EntryInterface
     */
    //public function findTrashed($id);

    /**
     * Create a new entry.
     *
     * @param  array $attributes
     * @return EntryInterface
     */
    public function create(array $attributes);

    /**
     * Save an entry.
     *
     * @param  EntryInterface $entry
     * @return bool
     */
    public function save(EntryInterface $entry);

    /**
     * Delete an entry.
     *
     * @param  EntryInterface $entry
     * @return bool
     */
    public function delete(EntryInterface $entry);

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

    /**
     * Truncate the entries.
     *
     * @return void
     */
    public function truncate();

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
