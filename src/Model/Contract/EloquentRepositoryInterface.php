<?php namespace Anomaly\Streams\Platform\Model\Contract;

use Anomaly\Streams\Platform\Model\EloquentModel;

/**
 * Interface EloquentRepositoryInterface
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Model\Contract
 */
interface EloquentRepositoryInterface
{

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
