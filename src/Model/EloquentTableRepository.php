<?php namespace Anomaly\Streams\Platform\Model;

use Anomaly\Streams\Platform\Ui\Table\Contract\TableRepositoryInterface;
use Anomaly\Streams\Platform\Ui\Table\Event\QueryHasStarted;
use Anomaly\Streams\Platform\Ui\Table\Table;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Support\Collection;

/**
 * Class EloquentTableRepositoryInterface
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Model
 */
class EloquentTableRepositoryInterface implements TableRepositoryInterface
{

    use DispatchesCommands;

    /**
     * The repository model.
     *
     * @var EloquentModel
     */
    protected $model;

    /**
     * Create a new EloquentModel instance.
     *
     * @param EloquentModel $model
     */
    public function __construct(EloquentModel $model)
    {
        $this->model = $model;
    }

    /**
     * Get the table entries.
     *
     * @param Table $table
     * @return Collection
     */
    public function get(Table $table)
    {
        // Get the options off the table.
        $options = $table->getOptions();

        // Start a new query.
        $query = $this->model->newQuery();

        /**
         * Prevent joins from overriding intended columns
         * by prefixing with the model's table name.
         */
        $query = $query->select($this->model->getTable() . '.*');

        /**
         * Eager load any relations to
         * save resources and queries.
         */
        $query = $query->with($options->get('eager', []));

        /**
         * Raise and fire an event here to allow
         * other things (including filters / views)
         * to modify the query before proceeding.
         */
        app('events')->fire(new QueryHasStarted($table, $query));

        /**
         * Before we actually adjust the baseline query
         * set the total amount of entries possible back
         * on the table so it can be used later.
         */
        $total = $query->count();

        $options->put('total_results', $total);

        /**
         * Assure that our page exists. If the page does
         * not exist then start walking backwards until
         * we find a page that is has something to show us.
         */
        $limit  = $options->get('limit', 15);
        $page   = app('request')->get('page', 1);
        $offset = $limit * ($page - 1);

        if ($total < $offset && $page > 1) {
            $url = str_replace('page=' . $page, 'page=' . ($page - 1), app('request')->fullUrl());

            header('Location: ' . $url);
        }

        /**
         * Limit the results to the limit and offset
         * based on the page if any.
         */
        $offset = $limit * (app('request')->get('page', 1) - 1);

        $query = $query->take($limit)->offset($offset);

        /**
         * Order the query results.
         */
        foreach ($options->get('order_by', ['id' => 'asc']) as $column => $direction) {
            $query = $query->orderBy($column, $direction);
        }

        return $query->get();
    }
}
