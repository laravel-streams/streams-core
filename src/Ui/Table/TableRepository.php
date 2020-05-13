<?php

namespace Anomaly\Streams\Platform\Ui\Table;

use Illuminate\Support\Collection;
use Anomaly\Streams\Platform\Ui\Table\Event\TableIsQuerying;
use Anomaly\Streams\Platform\Ui\Table\Event\TableWasQueried;
use Anomaly\Streams\Platform\Repository\Contract\RepositoryInterface;
use Anomaly\Streams\Platform\Ui\Table\Contract\TableRepositoryInterface;

/**
 * Class TableRepository
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class TableRepository implements TableRepositoryInterface
{

    /**
     * The repository instance.
     *
     * @var RepositoryInterface
     */
    protected $repository;

    /**
     * Create a new class instance.
     *
     * @param TableBuilder $builder
     * @param RepositoryInterface $repository
     */
    public function __construct(TableBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Get the table entries.
     *
     * @return Collection
     */
    public function get()
    {
        // Start a new entry criteria.
        $criteria = $this->builder->stream
            ->repository()
            ->newCriteria();

        /*
         * Raise and fire an event here to allow
         * other things (including filters / views)
         * to modify the query before proceeding.
         */
        $this->builder->fire('querying', [
            'builder' => $this->builder,
            'criteria' => $criteria
        ]);
        event(new TableIsQuerying($this->builder, $criteria));

        /*
         * Before we actually adjust the baseline query
         * set the total amount of entries possible back
         * on the table so it can be used later.
         *
         * We unset the orders on the query
         * because of pgsql grouping issues.
         */
        $total = $criteria->count();

        // @todo improve
        $this->builder->table->setOption('total_results', $total);

        /*
         * Assure that our page exists. If the page does
         * not exist then start walking backwards until
         * we find a page that is has something to show us.
         */
        $limit  = (int) app('request')->get(
            $this->builder->table->getOption('prefix') . 'limit',
            $this->builder->table->getOption('limit', config('streams.system.per_page', 15))
        );
        $page   = (int) app('request')->get($this->builder->table->getOption('prefix') . 'page', 1);
        $offset = $limit * (($page ?: 1) - 1);

        if ($total < $offset && $page > 1) {
            $url = str_replace(
                $this->builder->table->getOption('prefix') . 'page=' . $page,
                $this->builder->table->getOption('prefix') . 'page=' . ($page - 1),
                app('request')->fullUrl()
            );

            header('Location: ' . $url);
        }

        $criteria->limit($limit, $offset);

        /*
         * Order the query results.
         */
        if ($order = $this->builder->table->getOption('order_by')) {
            foreach ($order as $field => $direction) {

                /**
                 * @todo REVISIT: Let FTs override with their criteria class.
                 */
                $criteria->orderBy($field, $direction);
            }
        }

        if ($this->builder->table->getOption('sortable')) {
            $criteria->orderBy('sort_order', 'ASC');
        }

        // $builder->fire('queried', compact('builder', 'query'));
        // event(new TableWasQueried($builder, $query));
        return $criteria->get();
    }
}
