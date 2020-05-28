<?php

namespace Anomaly\Streams\Platform\Ui\Grid\Workflows\Build;

use Illuminate\Support\Collection;
use Anomaly\Streams\Platform\Ui\Grid\GridBuilder;
use Anomaly\Streams\Platform\Ui\Grid\Workflows\QueryWorkflow;
use Anomaly\Streams\Platform\Repository\Contract\RepositoryInterface;

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
     * @param GridBuilder $builder
     */
    public function handle(GridBuilder $builder)
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

            $builder->grid->entries = $builder->entries;

            return;
        }

        /*
         * Fallback to using the repository 
         * to get and/or paginate the results.
         */
        if ($builder->repository instanceof RepositoryInterface) {

            (new $builder->query_workflow)->process(compact('builder'));

            return;
        }
    }
}
