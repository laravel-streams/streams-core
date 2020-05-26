<?php

namespace Anomaly\Streams\Platform\Ui\Grid\Workflows;

use Anomaly\Streams\Platform\Workflow\Workflow;
use Anomaly\Streams\Platform\Ui\Grid\Workflows\Build\MakeGrid;
use Anomaly\Streams\Platform\Ui\Grid\Workflows\Build\SetStream;
use Anomaly\Streams\Platform\Ui\Grid\Workflows\Build\BuildItems;
use Anomaly\Streams\Platform\Ui\Grid\Workflows\Build\LoadAssets;
use Anomaly\Streams\Platform\Ui\Grid\Workflows\Build\SetOptions;
use Anomaly\Streams\Platform\Ui\Grid\Workflows\Build\BuildEntries;
use Anomaly\Streams\Platform\Ui\Grid\Workflows\Build\AuthorizeGrid;
use Anomaly\Streams\Platform\Ui\Grid\Workflows\Build\SetRepository;
use Anomaly\Streams\Platform\Ui\Grid\Workflows\Build\LoadBreadcrumb;

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
         * Make that Form.
         */
        MakeGrid::class,
        LoadAssets::class,
        LoadBreadcrumb::class,

        /**
         * Set initial attributes.
         */
        SetStream::class,
        SetOptions::class,
        SetRepository::class,
        
        /**
         * Load the entries.
         */
        BuildEntries::class,

        /**
         * Authorize the form.
         */
        AuthorizeGrid::class,

        /**
         * Build-er up.
         */
        BuildItems::class,
    ];
}
