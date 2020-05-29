<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Column\Workflows\Build;

use Anomaly\Streams\Platform\Workflow\Workflow;
use Anomaly\Streams\Platform\Ui\Support\Workflows\SetStream;
use Anomaly\Streams\Platform\Ui\Support\Workflows\LoadAssets;
use Anomaly\Streams\Platform\Ui\Support\Workflows\SetOptions;
use Anomaly\Streams\Platform\Ui\Support\Workflows\MakeInstance;

/**
 * Class BuildWorkflow
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
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
         * Make dat instance.
         */
        MakeInstance::class,

        /**
         * Integrate with others.
         */
        LoadAssets::class,

        /**
         * Set important things.
         */
        SetStream::class,
        SetOptions::class,

        /**
         * Build-er up.
         */
        // BuildFields::class,
        // BuildActions::class,
        // BuildButtons::class,
        // BuildSections::class,
    ];
}
