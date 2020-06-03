<?php

namespace Anomaly\Streams\Platform\Ui\Table;

use Anomaly\Streams\Platform\Ui\Table\Table;
use Anomaly\Streams\Platform\Ui\Support\Builder;
use Anomaly\Streams\Platform\Ui\Button\ButtonRegistry;
use Anomaly\Streams\Platform\Ui\Table\Workflows\BuildWorkflow;
use Anomaly\Streams\Platform\Ui\Table\Workflows\QueryWorkflow;
use Anomaly\Streams\Platform\Ui\Table\Component\Row\RowBuilder;
use Anomaly\Streams\Platform\Ui\Table\Component\View\ViewBuilder;
use Anomaly\Streams\Platform\Ui\Table\Component\View\ViewRegistry;
use Anomaly\Streams\Platform\Ui\Table\Component\Action\ActionBuilder;
use Anomaly\Streams\Platform\Ui\Table\Component\Button\ButtonBuilder;
use Anomaly\Streams\Platform\Ui\Table\Component\Column\ColumnBuilder;
use Anomaly\Streams\Platform\Ui\Table\Component\Filter\FilterBuilder;
use Anomaly\Streams\Platform\Ui\Table\Component\Action\ActionRegistry;
use Anomaly\Streams\Platform\Ui\Table\Component\Filter\FilterRegistry;

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

        'views_registry' => ViewRegistry::class,
        'view_builder' => ViewBuilder::class,

        'actions_registry' => ActionRegistry::class,
        'action_builder' => ActionBuilder::class,

        'filters_registry' => FilterRegistry::class,
        'filter_builder' => FilterBuilder::class,

        'buttons_registry' => ButtonRegistry::class,
        'button_builder' => ButtonBuilder::class,

        //'columns_registry' => ColumnRegistry::class,
        'column_builder' => ColumnBuilder::class,
        'row_builder' => RowBuilder::class,

        'build_workflow' => BuildWorkflow::class,
        'query_workflow' => QueryWorkflow::class,
    ];
}
