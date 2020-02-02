<?php

namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Ui\Table\Component\Action\ActionBuilder;
use Anomaly\Streams\Platform\Ui\Table\Component\Action\Command\SetActiveAction;
use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Command\SetActiveFilters;
use Anomaly\Streams\Platform\Ui\Table\Component\Filter\FilterBuilder;
use Anomaly\Streams\Platform\Ui\Table\Component\Header\Command\BuildHeaders;
use Anomaly\Streams\Platform\Ui\Table\Component\Header\HeaderBuilder;
use Anomaly\Streams\Platform\Ui\Table\Component\Row\RowBuilder;
use Anomaly\Streams\Platform\Ui\Table\Component\View\Command\SetActiveView;
use Anomaly\Streams\Platform\Ui\Table\Component\View\ViewBuilder;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

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
        /*
         * Resolve and set the table model and stream.
         */
        dispatch_now(new SetTableModel($this->builder));
        dispatch_now(new SetTableStream($this->builder));
        dispatch_now(new SetDefaultParameters($this->builder));
        dispatch_now(new SetRepository($this->builder));

        /*
         * Build table views and mark active.
         */
        ViewBuilder::build($this->builder);
        dispatch_now(new SetActiveView($this->builder));

        /**
         * Set the table options going forward.
         */
        dispatch_now(new SetTableOptions($this->builder));
        dispatch_now(new SetDefaultOptions($this->builder));
        dispatch_now(new SaveTableState($this->builder));

        /*
         * Before we go any further, authorize the request.
         */
        dispatch_now(new AuthorizeTable($this->builder));

        /*
         * Build table filters and flag active.
         */
        FilterBuilder::build($this->builder);
        dispatch_now(new SetActiveFilters($this->builder));

        /*
         * Build table actions and flag active.
         */
        ActionBuilder::build($this->builder);
        dispatch_now(new SetActiveAction($this->builder));

        /*
         * Build table headers.
         */
        HeaderBuilder::build($this->builder);
        //dispatch_now(new EagerLoadRelations($this->builder)); // @todo Axe this?

        /*
         * Get table entries.
         */
        dispatch_now(new GetTableEntries($this->builder));

        /*
         * Lastly table rows.
         */
        RowBuilder::build($this->builder);
    }
}
