<?php

namespace Anomaly\Streams\Platform\Ui\Grid;

use Illuminate\Support\Facades\Response;
use Anomaly\Streams\Platform\Ui\Grid\Grid;
use Anomaly\Streams\Platform\Ui\Support\Builder;
use Anomaly\Streams\Platform\Traits\FiresCallbacks;
use Anomaly\Streams\Platform\Support\Traits\Properties;
use Anomaly\Streams\Platform\Ui\Grid\Workflows\BuildWorkflow;
use Anomaly\Streams\Platform\Ui\Grid\Workflows\QueryWorkflow;

/**
 * Class GridBuilder
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class GridBuilder extends Builder
{

    /**
     * The builder attributes.
     *
     * @var array
     */
    protected $attributes = [
        'stream' => null,
        'repository' => null,

        'entry' => null,

        'assets' => [],
        'options' => [],
        'buttons' => [],
        'items' => [],

        'component' => 'grid',

        'grid' => Grid::class,

        'build_workflow' => BuildWorkflow::class,
        'query_workflow' => QueryWorkflow::class,
    ];
}
