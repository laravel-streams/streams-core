<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Column\Workflows;

use Anomaly\Streams\Platform\Workflow\Workflow;
use Anomaly\Streams\Platform\Ui\Support\Workflows\BuildComponents;
use Anomaly\Streams\Platform\Ui\Support\Workflows\ResolveComponents;
use Anomaly\Streams\Platform\Ui\Table\Component\Column\Workflows\Columns\DefaultColumns;
use Anomaly\Streams\Platform\Ui\Table\Component\Column\Workflows\Columns\NormalizeColumns;

/**
 * Class ColumnsWorkflow
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class ColumnsWorkflow extends Workflow
{

    /**
     * The build steps.
     *
     * @var array
     */
    protected $steps = [
        'resolve_columns' => ResolveComponents::class,

        DefaultColumns::class,
        NormalizeColumns::class,

        //'merge_columns' => MergeComponents::class,

        //'translate_columns' => TranslateComponents::class,
        //'parse_columns' => ParseComponents::class,

        'build_columns' => BuildComponents::class,
    ];
}
