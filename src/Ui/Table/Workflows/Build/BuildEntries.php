<?php

namespace Anomaly\Streams\Platform\Ui\Table\Workflows\Build;

use Anomaly\Streams\Platform\Repository\Contract\RepositoryInterface;
use Illuminate\Support\Collection;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class BuildEntries
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class BuildEntries
{

    /**
     * Handle the command.
     * 
     * @param TableBuilder $builder
     */
    public function handle(TableBuilder $builder)
    {

        /*
         * If the builder has an entries handler
         * then call it through the container and
         * let it load the entries itself.
         */
        if (is_string($builder->entries) || $builder->entries instanceof \Closure) {

            $entries = resolver($builder->entries, compact('builder'));

            $builder->entries = evaluate($entries ?: $builder->entries, compact('builder'));

            return;
        }

        /**
         * If the builder already has a collection
         * of entries set on it then use those.
         */
        if ($builder->entries instanceof Collection) {

            $builder->table->entries = $builder->entries;

            return;
        }

        /*
         * Fallback to using the repository 
         * to fetch and paginate the results.
         */
        if ($builder->repository instanceof RepositoryInterface) {

            $builder->table->pagination = $builder->repository->newCriteria()->paginate([
                'page_name' => $builder->table->options->get('prefix') . 'page',
                'limit_name' => $builder->table->options->get('limit') . 'limit',
            ]);

            $builder->table->entries = $builder->table->pagination->getCollection();

            return;
        }
    }
}
