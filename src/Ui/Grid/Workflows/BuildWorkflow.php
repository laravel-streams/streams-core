<?php

namespace Anomaly\Streams\Platform\Ui\Tree\Workflows;

use Anomaly\Streams\Platform\Workflow\Workflow;
use Anomaly\Streams\Platform\Ui\Tree\Workflows\Build\MakeTree;
use Anomaly\Streams\Platform\Ui\Tree\Workflows\Build\SetStream;
use Anomaly\Streams\Platform\Ui\Tree\Workflows\Build\LoadAssets;
use Anomaly\Streams\Platform\Ui\Tree\Workflows\Build\SetOptions;
use Anomaly\Streams\Platform\Ui\Tree\Workflows\Build\BuildEntries;
use Anomaly\Streams\Platform\Ui\Tree\Workflows\Build\AuthorizeTree;
use Anomaly\Streams\Platform\Ui\Tree\Workflows\Build\BuildSegments;
use Anomaly\Streams\Platform\Ui\Tree\Workflows\Build\SetRepository;
use Anomaly\Streams\Platform\Ui\Tree\Workflows\Build\LoadBreadcrumb;

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
        MakeTree::class,
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
        AuthorizeTree::class,

        /**
         * Build-er up.
         */
        BuildSegments::class,
    ];
}
