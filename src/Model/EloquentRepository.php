<?php namespace Anomaly\Streams\Platform\Model;

use Anomaly\Streams\Platform\Model\Contract\EloquentRepositoryInterface;

/**
 * Class EloquentRepository
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Model
 */
class EloquentRepository implements EloquentRepositoryInterface
{

    /**
     * Return all records.
     *
     * @return EloquentCollection
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * Find a record by it's ID.
     *
     * @param $id
     * @return EloquentModel
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    /**
     * Create a new record.
     *
     * @param array $attributes
     * @return EloquentModel
     */
    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    /**
     * Save a record.
     *
     * @param EloquentModel $entry
     * @return bool
     */
    public function save(EloquentModel $entry)
    {
        return $entry->save();
    }

    /**
     * Delete a record.
     *
     * @param EloquentModel $entry
     * @return bool
     */
    public function delete(EloquentModel $entry)
    {
        return $entry->delete();
    }
}
