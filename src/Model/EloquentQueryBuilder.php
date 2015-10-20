<?php namespace Anomaly\Streams\Platform\Model;

use Anomaly\Streams\Platform\Assignment\AssignmentModel;
use Anomaly\Streams\Platform\Collection\CacheCollection;
use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class EloquentQueryBuilder
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Model
 */
class EloquentQueryBuilder extends Builder
{

    /**
     * The model being queried.
     *
     * @var EloquentModel
     */
    protected $model;

    /**
     * Execute the query as a "select" statement.
     *
     * @param  array $columns
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function get($columns = ['*'])
    {
        $this->orderByDefault();

        /*if (!env('APP_DEBUG') || env('DB_CACHE')) {

            $this->rememberIndex();

            if ($this->model->getCacheMinutes()) {
                return app('cache')->remember(
                    $this->getCacheKey(),
                    $this->model->getCacheMinutes(),
                    function () use ($columns) {
                        return parent::get($columns);
                    }
                );
            }
        }*/

        return parent::get($columns);
    }

    /**
     * Remember and index.
     *
     * @return $this
     */
    protected function rememberIndex()
    {
        if ($this->model->getCacheMinutes()) {
            $this->indexCacheCollection();
        }

        return $this;
    }

    /**
     * Index cache collection
     *
     * @return object
     */
    protected function indexCacheCollection()
    {
        (new CacheCollection())
            ->make([$this->getCacheKey()])
            ->setKey($this->model->getCacheCollectionKey())
            ->index();

        return $this;
    }

    /**
     * Get the unique cache key for the query.
     *
     * @return string
     */
    public function getCacheKey()
    {
        $name = $this->model->getConnectionName();

        return md5($name . $this->toSql() . serialize($this->getBindings()));
    }

    /**
     * Get fresh models / disable cache
     *
     * @param  boolean $fresh
     * @return object
     */
    public function fresh($fresh = true)
    {
        if ($fresh) {
            $this->model->setCacheMinutes(0);
        }

        return $this;
    }

    /**
     * Update a record in the database.
     *
     * @param array $values
     * @return int
     */
    public function update(array $values)
    {
        $this->model->fireEvent('updatingMultiple');

        $return = parent::update($values);

        $this->model->fireEvent('updatedMultiple');

        return $return;
    }

    /**
     * Delete a record from the database.
     *
     * @return mixed
     */
    public function delete()
    {
        $this->model->fireEvent('deletingMultiple');

        $return = parent::delete();

        $this->model->fireEvent('deletedMultiple');

        return $return;
    }

    /**
     * Order by sort_order if null.
     */
    protected function orderByDefault()
    {
        $model = $this->getModel();
        $query = $this->getQuery();

        if ($query->orders === null) {
            if ($model instanceof AssignmentModel) {
                $query->orderBy('sort_order', 'ASC');
            } elseif ($model instanceof EntryInterface) {
                if ($model->getStream()->isSortable()) {
                    $query->orderBy('sort_order', 'ASC');
                }
            }
        }
    }
}
