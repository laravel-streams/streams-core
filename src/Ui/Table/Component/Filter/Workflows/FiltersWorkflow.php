<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Filter\Workflows;

use Anomaly\Streams\Platform\Workflow\Workflow;
use Anomaly\Streams\Platform\Ui\Support\Workflows\BuildComponents;
use Anomaly\Streams\Platform\Ui\Support\Workflows\MergeComponents;
use Anomaly\Streams\Platform\Ui\Support\Workflows\ParseComponents;
use Anomaly\Streams\Platform\Ui\Support\Workflows\ResolveComponents;
use Anomaly\Streams\Platform\Ui\Support\Workflows\TranslateComponents;
use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Workflows\Filters\DefaultFilters;
use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Workflows\Filters\SetActiveFilter;
use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Workflows\Filters\NormalizeFilters;

/**
 * Class FiltersWorkflow
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class FiltersWorkflow extends Workflow
{

    /**
     * The build steps.
     *
     * @var array
     */
    protected $steps = [
        'resolve_filters' => ResolveComponents::class,

        DefaultFilters::class,
        NormalizeFilters::class,

        'merge_filters' => MergeComponents::class,

        'translate_filters' => TranslateComponents::class,
        'parse_filters' => ParseComponents::class,

        'build_filters' => BuildComponents::class,

        SetActiveFilter::class,
    ];
}
