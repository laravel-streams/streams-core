<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Ui\Table\Component\Action\Command\BuildActions;
use Anomaly\Streams\Platform\Ui\Table\Component\Action\Command\SetActiveAction;
use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Command\BuildFilters;
use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Command\SetActiveFilters;
use Anomaly\Streams\Platform\Ui\Table\Component\Header\Command\BuildHeaders;
use Anomaly\Streams\Platform\Ui\Table\Component\Row\Command\BuildRows;
use Anomaly\Streams\Platform\Ui\Table\Component\View\Command\BuildViews;
use Anomaly\Streams\Platform\Ui\Table\Component\View\Command\SetActiveView;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class BuildTable
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class BuildTable
{

    use DispatchesJobs;

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
        dispatch_sync(new SetTableModel($this->builder));
        dispatch_sync(new SetTableStream($this->builder));
        dispatch_sync(new SetDefaultParameters($this->builder));
        dispatch_sync(new SetRepository($this->builder));

        /*
         * Build table views and mark active.
         */
        dispatch_sync(new BuildViews($this->builder));
        dispatch_sync(new SetActiveView($this->builder));

        /**
         * Set the table options going forward.
         */
        dispatch_sync(new SetTableOptions($this->builder));
        dispatch_sync(new SetDefaultOptions($this->builder));
        dispatch_sync(new SaveTableState($this->builder));

        /*
         * Before we go any further, authorize the request.
         */
        dispatch_sync(new AuthorizeTable($this->builder));

        /*
         * Build table filters and flag active.
         */
        dispatch_sync(new BuildFilters($this->builder));
        dispatch_sync(new SetActiveFilters($this->builder));

        /*
         * Build table actions and flag active.
         */
        dispatch_sync(new BuildActions($this->builder));
        dispatch_sync(new SetActiveAction($this->builder));

        /*
         * Build table headers.
         */
        dispatch_sync(new BuildHeaders($this->builder));
        dispatch_sync(new EagerLoadRelations($this->builder));

        /*
         * Get table entries.
         */
        dispatch_sync(new GetTableEntries($this->builder));

        /*
         * Lastly table rows.
         */
        dispatch_sync(new BuildRows($this->builder));
    }
}
