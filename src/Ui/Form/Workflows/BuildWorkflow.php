<?php

namespace Anomaly\Streams\Platform\Ui\Form\Workflows;

use Anomaly\Streams\Platform\Workflow\Workflow;
use Anomaly\Streams\Platform\Ui\Form\Workflows\Build\BuildRows;
use Anomaly\Streams\Platform\Ui\Form\Workflows\Build\MakeForm;
use Anomaly\Streams\Platform\Ui\Form\Workflows\Build\SetStream;
use Anomaly\Streams\Platform\Ui\Form\Workflows\Build\LoadAssets;
use Anomaly\Streams\Platform\Ui\Form\Workflows\Build\SetOptions;
use Anomaly\Streams\Platform\Ui\Form\Workflows\Build\BuildActions;
use Anomaly\Streams\Platform\Ui\Form\Workflows\Build\BuildEntries;
use Anomaly\Streams\Platform\Ui\Form\Workflows\Build\SetRepository;
use Anomaly\Streams\Platform\Ui\Form\Workflows\Build\AuthorizeForm;
use Anomaly\Streams\Platform\Ui\Form\Workflows\Build\LoadBreadcrumb;
use Anomaly\Streams\Platform\Ui\Form\Component\View\Command\BuildViews;
use Anomaly\Streams\Platform\Ui\Form\Component\Filter\Command\BuildFilters;

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
        MakeForm::class,
        LoadAssets::class,
        LoadBreadcrumb::class,

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
         * we can authorize the Form access.
         */
        AuthorizeForm::class,

        /**
         * Build the rest of the Form.
         */
        BuildActions::class,
        BuildFilters::class,
        BuildEntries::class,
        BuildRows::class,
    ];
}
