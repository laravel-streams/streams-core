<?php

namespace Anomaly\Streams\Platform\Model\Contract;

use Anomaly\Streams\Platform\Model\EloquentCollection;
use Anomaly\Streams\Platform\Model\EloquentModel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Interface EloquentRepositoryInterface.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Model\Contract
 */
interface EloquentRepositoryInterface
{
    /**
     * Return all records.
     *
     * @return EloquentCollection
     */
    public function all();

    /**
     * Find a record by it's ID.
     *
     * @param $id
     * @return EloquentModel
     */
    public function find($id);

    /**
     * Create a new record.
     *
     * @param array $attributes
     * @return EloquentModel
     */
    public function create(array $attributes);

    /**
     * Return a new instance.
     *
     * @return EloquentModel
     */
    public function newInstance();

    /**
     * Return a paginated collection.
     *
     * @param array $parameters
     * @return LengthAwarePaginator
     */
    public function paginate(array $parameters = []);

    /**
     * Save a record.
     *
     * @param EloquentModel $entry
     * @return bool
     */
    public function save(EloquentModel $entry);

    /**
     * Delete a record.
     *
     * @param EloquentModel $entry
     * @return bool
     */
    public function delete(EloquentModel $entry);
}
