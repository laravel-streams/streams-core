<?php

namespace Anomaly\Streams\Platform\Ui\Grid\Workflows;

use Anomaly\Streams\Platform\Workflow\Workflow;
use Anomaly\Streams\Platform\Ui\Grid\Workflows\Query\StartQuery;
use Anomaly\Streams\Platform\Ui\Grid\Workflows\Query\FilterQuery;
use Anomaly\Streams\Platform\Ui\Grid\Workflows\Query\FinishQuery;

/**
 * Class QueryWorkflow
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class QueryWorkflow extends Workflow
{

    /**
     * The build steps.
     *
     * @var array
     */
    protected $steps = [

        /**
         * Query dem results.
         */
        StartQuery::class,
        //FilterQuery::class, // No filters..
        FinishQuery::class,
    ];
}
