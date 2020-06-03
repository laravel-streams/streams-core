<?php

namespace Anomaly\Streams\Platform\Ui\Table\Workflows\Build;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Anomaly\Streams\Platform\Ui\Table\Workflows\QueryWorkflow;
use Anomaly\Streams\Platform\Repository\Contract\RepositoryInterface;
use Anomaly\Streams\Platform\Ui\Table\Workflows\EntriesWorkflow;

/**
 * Class QueryEntries
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class QueryEntries
{

    /**
     * Handle the command.
     * 
     * @param TableBuilder $builder
     */
    public function handle(TableBuilder $builder)
    {

        if ($builder->entries === false) {
            return;
        }

        (new QueryWorkflow())->process([
            'builder' => $builder,
        ]);
    }
}
