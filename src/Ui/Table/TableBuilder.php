<?php

namespace Anomaly\Streams\Platform\Ui\Table;

use Anomaly\Streams\Platform\Ui\Table\Table;
use Anomaly\Streams\Platform\Ui\Support\Builder;
use Anomaly\Streams\Platform\Ui\Table\Workflows\BuildWorkflow;
use Anomaly\Streams\Platform\Ui\Table\Workflows\QueryWorkflow;

/**
 * Class TableBuilder
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class TableBuilder extends Builder
{

    /**
     * The builder attributes.
     *
     * @var array
     */
    protected $attributes = [
        'async' => false,

        'stream' => null,
        'entries' => null,
        'repository' => null,

        'views' => [],
        'assets' => [],
        'filters' => [],
        'columns' => [],
        'buttons' => [],
        'actions' => [],
        'options' => [],

        'component' => 'table',

        'table' => Table::class,
        
        'build_workflow' => BuildWorkflow::class,
        'query_workflow' => QueryWorkflow::class,
    ];
}
