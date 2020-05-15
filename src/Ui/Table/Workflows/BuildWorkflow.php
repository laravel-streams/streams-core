<?php

namespace Anomaly\Streams\Platform\Ui\Table\Workflows;

use Anomaly\Streams\Platform\Workflow\Workflow;
use Anomaly\Streams\Platform\Ui\Table\Workflows\Build\BuildRows;
use Anomaly\Streams\Platform\Ui\Table\Workflows\Build\LoadTable;
use Anomaly\Streams\Platform\Ui\Table\Workflows\Build\MakeTable;
use Anomaly\Streams\Platform\Ui\Table\Workflows\Build\SetStream;
use Anomaly\Streams\Platform\Ui\Table\Workflows\Build\SetOptions;
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
         * Make that table.
         */
        MakeTable::class,
        LoadTable::class,

        /**
         * Set initial attributes.
         */
        SetStream::class,
        SetOptions::class,
        SetRepository::class,

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
         * Build the rest of the table.
         */
        BuildActions::class,
        BuildFilters::class,
        BuildEntries::class,
        BuildRows::class,

        // -------------
        LoadTable::class,

        // if ($breadcrumb = $table->options->get('breadcrumb')) {
        //     $breadcrumbs->put($breadcrumb, '#');
        // }
    ];
}
