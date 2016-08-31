<?php namespace Anomaly\Streams\Platform\Ui\Table;

use Anomaly\Streams\Platform\Ui\Table\Contract\TableRepositoryInterface;
use Anomaly\Streams\Platform\Ui\Table\Event\TableIsQuerying;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class TableRepository implements TableRepositoryInterface
{
    use DispatchesJobs;

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
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get the table entries.
     *
     * @param  TableBuilder $builder
     * @return Collection
     */
    public function get(TableBuilder $builder)
    {
        // Grab any stream we have.
        $stream = $builder->getTableStream();

        // Start a new query.
        $query = $this->model->newQuery();

        /*
         * Prevent joins from overriding intended columns
         * by prefixing with the model's table name.
         */
        $query = $query->select($this->model->getTable() . '.*');

        /*
         * Eager load any relations to
         * save resources and queries.
         */
        $query = $query->with($builder->getTableOption('eager', []));

        /*
         * Raise and fire an event here to allow
         * other things (including filters / views)
         * to modify the query before proceeding.
         */
        $builder->fire('querying', compact('builder', 'query'));
        app('events')->fire(new TableIsQuerying($builder, $query));

        /*
         * Before we actually adjust the baseline query
         * set the total amount of entries possible back
         * on the table so it can be used later.
         */
        $total = clone($query);

        $total = $total
            ->select($this->model->getTable() . '.id')
            ->groupBy($this->model->getTable() . '.id')
            ->count($this->model->getTable() . '.id');

        $builder->setTableOption('total_results', $total);

        /*
         * Assure that our page exists. If the page does
         * not exist then start walking backwards until
         * we find a page that is has something to show us.
         */
        $limit  = (int)$builder->getTableOption('limit', config('streams::system.per_page', 15));
        $page   = app('request')->get($builder->getTableOption('prefix') . 'page', 1);
        $offset = $limit * ($page - 1);

        if ($total < $offset && $page > 1) {
            $url = str_replace(
                $builder->getTableOption('prefix') . 'page=' . $page,
                $builder->getTableOption('prefix') . 'page=' . ($page - 1),
                app('request')->fullUrl()
            );

            header('Location: ' . $url);
        }

        /*
         * Limit the results to the limit and offset
         * based on the page if any.
         */
        $offset = $limit * (app('request')->get($builder->getTableOption('prefix') . 'page', 1) - 1);

        $query = $query->take($limit)->offset($offset);

        /*
         * Order the query results.
         */
        if ($order = $builder->getTableOption('order_by')) {
            foreach ($order as $column => $direction) {
                if ($stream && $utility = $stream->getFieldTypeQuery($column)) {
                    $utility->orderBy($query, $direction);
                } else {
                    $query = $query->orderBy($column, $direction);
                }
            }
        }

        if ($builder->getTableOption('sortable')) {
            $query = $query->orderBy('sort_order', 'ASC');
        }

        return $query->get();
    }
}
