<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\View\Workflows;

use Anomaly\Streams\Platform\Workflow\Workflow;
use Anomaly\Streams\Platform\Ui\Support\Workflows\SetStream;
use Anomaly\Streams\Platform\Ui\Support\Workflows\LoadAssets;
use Anomaly\Streams\Platform\Ui\Support\Workflows\SetOptions;
use Anomaly\Streams\Platform\Ui\Support\Workflows\MakeInstance;
use Anomaly\Streams\Platform\Ui\Support\Workflows\MakeComponent;
use Anomaly\Streams\Platform\Ui\Support\Workflows\ResolveComponent;
use Anomaly\Streams\Platform\Ui\Table\Component\Column\Workflows\Build\NormalizeComponent;

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
         * Integrate with others.
         */
        LoadAssets::class,

        /**
         * Set important things.
         */
        SetStream::class,
        SetOptions::class,

        /**
         * Process input.
         */
        ResolveComponent::class,
        NormalizeComponent::class,
        
        /**
         * Build and configure.
         */
        //MakeComponent::class,
    ];
}
