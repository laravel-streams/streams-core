<?php

namespace Anomaly\Streams\Platform\Ui\Form\Workflows\Build;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Anomaly\Streams\Platform\Asset\Facades\Assets;
use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Support\Breadcrumb;
use Anomaly\Streams\Platform\Repository\Contract\RepositoryInterface;
use Anomaly\Streams\Platform\Ui\Form\Workflows\QueryWorkflow;

/**
 * Class SetEntry
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class SetEntry
{

    /**
     * Handle the command.
     * 
     * @param FormBuilder $builder
     */
    public function handle(FormBuilder $builder)
    {

        /*
         * If the builder has an entry handler
         * then call it through the container and
         * let it load the entry itself.
         */
        if (
            (is_string($builder->entry) && class_exists($builder->entry))
            || $builder->entry instanceof \Closure
            ) {
            
            $entry = resolver($builder->entry, compact('builder'));

            $builder->entry = evaluate($entry ?: $builder->entry, compact('builder'));

            return;
        }

        /**
         * If the builder already has
         * an entry then just use that.
         */
        if ($builder->entry instanceof EntryInterface) {

            $builder->table->entry = $builder->entry;

            return;
        }

        /*
         * Fallback to using the repository 
         * to get and/or paginate the results.
         */
        if ($builder->repository instanceof RepositoryInterface) {

            (new QueryWorkflow)->process([
                'builder' => $builder
            ]);

            return;
        }
    }
}
