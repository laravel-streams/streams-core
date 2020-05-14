<?php

namespace Anomaly\Streams\Platform\Ui\Table\Workflows;

use Anomaly\Streams\Platform\Workflow\Workflow;
use Anomaly\Streams\Platform\Ui\Table\Workflows\Build\LoadTable;
use Anomaly\Streams\Platform\Ui\Table\Workflows\Build\BuildRows;
use Anomaly\Streams\Platform\Ui\Table\Workflows\Build\MakeTable;
use Anomaly\Streams\Platform\Ui\Table\Workflows\Build\SetStream;
use Anomaly\Streams\Platform\Ui\Table\Workflows\Build\BuildActions;
use Anomaly\Streams\Platform\Ui\Table\Workflows\Build\BuildEntries;
use Anomaly\Streams\Platform\Ui\Table\Workflows\Build\SetRepository;
use Anomaly\Streams\Platform\Ui\Table\Workflows\Build\AuthorizeTable;
use Anomaly\Streams\Platform\Ui\Table\Component\View\Command\BuildViews;
use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Command\BuildFilters;

/**
 * Class BuildWorkflow
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class BuildWorkflow extends Workflow
{

    /**
     * The build steps.
     *
     * @var array
     */
    protected $steps = [

        /**
         * Set critical attributes.
         */
        SetStream::class,
        SetRepository::class,

        /**
         * Make the table instance.
         */
        MakeTable::class,

        /**
         * Views can change nearly any aspect 
         * after this point so build them early.
         */
        BuildViews::class,

        /**
         * After views have had their way
         * we can authorize the table access.
         */
        AuthorizeTable::class,

        /**
         * Build and execute actions
         * at this point to allow short
         * circuiting the following steps.
         */
        BuildActions::class,
        //ExecuteAction::class,

        BuildFilters::class,
        BuildEntries::class,
        BuildRows::class,


        // -------------
        LoadTable::class,
    ];
}
