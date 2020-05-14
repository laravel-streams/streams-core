<?php

namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Workflow\Workflow;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Anomaly\Streams\Platform\Ui\Table\Component\Row\RowBuilder;
use Anomaly\Streams\Platform\Ui\Table\Component\View\ViewBuilder;
use Anomaly\Streams\Platform\Ui\Table\Component\Action\ActionBuilder;
use Anomaly\Streams\Platform\Ui\Table\Component\Filter\FilterBuilder;
use Anomaly\Streams\Platform\Ui\Table\Component\Header\HeaderBuilder;
use Anomaly\Streams\Platform\Ui\Table\Component\View\Command\SetActiveView;
use Anomaly\Streams\Platform\Ui\Table\Component\Action\Command\SetActiveAction;
use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Command\SetActiveFilters;

/**
 * Class BuildTable
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class BuildTable
{

    /**
     * The table builder.
     *
     * @var TableBuilder
     */
    protected $builder;

    /**
     * Create a new BuildTableColumnsCommand instance.
     *
     * @param TableBuilder $builder
     */
    public function __construct(TableBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Handle the command.
     */
    public function handle()
    {
        $workflow = new Workflow([

            /*
            * Resolve and set the table model and stream.
            */
            SetStream::class,
            SetRepository::class,

            /*
            * Build table views and mark active.
            */
            ViewBuilder::class,
            'set_active_view' => function () {
                dispatch_now(new SetActiveView($this->builder));
            },

            /*
            * Before we go any further, authorize the request.
            */
            AuthorizeTable::class,

            /**
             * Set the table options going forward.
             */
            SetTableOptions::class,
            SetDefaultOptions::class,
            SaveTableState::class,

            /*
            * Build table filters and flag active.
            */
            'filter_builder' => function () {
                FilterBuilder::build($this->builder);
            },
            SetActiveFilters::class,

            /*
            * Build table actions and flag active.
            */
            'action_builder' => function () {
                ActionBuilder::build($this->builder);
            },
            SetActiveAction::class,

            /*
            * Build table headers.
            */
            'header_builder' => function () {
                HeaderBuilder::build($this->builder);
            },

            /*
            * Get table entries.
            */
            GetTableEntries::class,

            /*
            * Lastly table rows.
            */
            'row_builder' => function () {
                RowBuilder::build($this->builder);
            },
        ]);

        /**
         * Process the workflow.
         */
        $workflow->process(['builder' => $this->builder]);
    }
}
