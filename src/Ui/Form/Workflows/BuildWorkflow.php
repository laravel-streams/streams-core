<?php

namespace Anomaly\Streams\Platform\Ui\Form\Workflows;

use Anomaly\Streams\Platform\Workflow\Workflow;
use Anomaly\Streams\Platform\Ui\Form\Workflows\Build\MakeForm;
use Anomaly\Streams\Platform\Ui\Form\Workflows\Build\SetEntry;
use Anomaly\Streams\Platform\Ui\Form\Workflows\Build\SetStream;
use Anomaly\Streams\Platform\Ui\Form\Workflows\Build\LoadAssets;
use Anomaly\Streams\Platform\Ui\Form\Workflows\Build\SetOptions;
use Anomaly\Streams\Platform\Ui\Form\Workflows\Build\BuildFields;
use Anomaly\Streams\Platform\Ui\Form\Workflows\Build\BuildActions;
use Anomaly\Streams\Platform\Ui\Form\Workflows\Build\BuildButtons;
use Anomaly\Streams\Platform\Ui\Form\Workflows\Build\AuthorizeForm;
use Anomaly\Streams\Platform\Ui\Form\Workflows\Build\BuildSections;
use Anomaly\Streams\Platform\Ui\Form\Workflows\Build\SetRepository;
use Anomaly\Streams\Platform\Ui\Form\Workflows\Build\LoadBreadcrumb;
use Anomaly\Streams\Platform\Ui\Form\Component\Section\SectionBuilder;
use Anomaly\Streams\Platform\Ui\Form\Component\Action\Command\SetActiveAction;

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
         * Load the entry.
         */
        SetEntry::class,

        /**
         * Authorize the form.
         */
        AuthorizeForm::class,

        /**
         * Build-er up.
         */
        BuildFields::class,
        BuildActions::class,
        BuildButtons::class,
        BuildSections::class,
    ];
}
