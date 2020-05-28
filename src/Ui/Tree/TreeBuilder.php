<?php

namespace Anomaly\Streams\Platform\Ui\Tree;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Anomaly\Streams\Platform\Ui\Support\Builder;
use Anomaly\Streams\Platform\Traits\FiresCallbacks;
use Anomaly\Streams\Platform\Support\Traits\Properties;
use Anomaly\Streams\Platform\Ui\Tree\Workflows\BuildWorkflow;
use Anomaly\Streams\Platform\Ui\Tree\Workflows\QueryWorkflow;

/**
 * Class TreeBuilder
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class TreeBuilder extends Builder
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
        'segments' => [],

        'component' => 'tree',

        'tree' => Tree::class,

        'build_workflow' => BuildWorkflow::class,
        'query_workflow' => QueryWorkflow::class,
    ];
}
