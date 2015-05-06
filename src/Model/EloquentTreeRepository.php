<?php namespace Anomaly\Streams\Platform\Model;

use Anomaly\Streams\Platform\Ui\Tree\Contract\TreeRepositoryInterface;
use Anomaly\Streams\Platform\Ui\Tree\Event\TreeIsQuerying;
use Anomaly\Streams\Platform\Ui\Tree\TreeBuilder;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Support\Collection;

/**
 * Class EloquentTreeRepositoryInterface
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Model
 */
class EloquentTreeRepository implements TreeRepositoryInterface
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
     * Get the tree entries.
     *
     * @param TreeBuilder $builder
     * @return Collection
     */
    public function get(TreeBuilder $builder)
    {
        // Start a new query.
        $query = $this->model->newQuery();

        /**
         * Prevent joins from overriding intended columns
         * by prefixing with the model's tree name.
         */
        $query = $query->select($this->model->getTable() . '.*');

        /**
         * Eager load any relations to
         * save resources and queries.
         */
        $query = $query->with($builder->getTreeOption('eager', []));

        /**
         * Raise and fire an event here to allow
         * other things (including filters / views)
         * to modify the query before proceeding.
         */
        $builder->fire('querying', compact('builder', 'query'));
        app('events')->fire(new TreeIsQuerying($builder, $query));

        /**
         * Before we actually adjust the baseline query
         * set the total amount of entries possible back
         * on the tree so it can be used later.
         */
        $total = $query->count();

        $builder->setTreeOption('total_results', $total);

        /**
         * Order the query results.
         */
        foreach ($builder->getTreeOption('order_by', ['sort_order' => 'asc']) as $column => $direction) {
            $query = $query->orderBy($column, $direction);
        }

        return $query->get();
    }

    /**
     * Save the tree.
     *
     * @param TreeBuilder $builder
     * @param array       $items
     * @param null        $parent
     */
    public function save(TreeBuilder $builder, array $items = [], $parent = null)
    {
        $model = $builder->getTreeModel();

        $items = $items ?: $builder->getRequestValue('items');

        foreach ($items as $index => $item) {
            $model
                ->newQuery()
                ->where('id', $item['id'])
                ->update(
                    [
                        $builder->getTreeOption('sort_column', 'sort_order')  => $index,
                        $builder->getTreeOption('parent_column', 'parent_id') => $parent
                    ]
                );

            if (isset($item['children'])) {
                $this->save($builder, $item['children'], $item['id']);
            }
        }
    }
}
