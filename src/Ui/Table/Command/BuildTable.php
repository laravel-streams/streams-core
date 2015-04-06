<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Ui\Table\Component\Action\Command\BuildActions;
use Anomaly\Streams\Platform\Ui\Table\Component\Action\Command\SetActiveAction;
use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Command\BuildFilters;
use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Command\SetActiveFilters;
use Anomaly\Streams\Platform\Ui\Table\Component\Header\Command\BuildHeaders;
use Anomaly\Streams\Platform\Ui\Table\Component\Row\Command\BuildRows;
use Anomaly\Streams\Platform\Ui\Table\Component\View\Command\BuildViews;
use Anomaly\Streams\Platform\Ui\Table\Component\View\Command\SetActiveView;
use Anomaly\Streams\Platform\Ui\Table\Event\TableIsBuilding;
use Anomaly\Streams\Platform\Ui\Table\Event\TableWasBuilt;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Events\Dispatcher;
use Illuminate\Foundation\Bus\DispatchesCommands;

/**
 * Class BuildTable
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Command
 */
class BuildTable implements SelfHandling
{

    use DispatchesCommands;

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
     *
     * @param Dispatcher $events
     */
    public function handle(Dispatcher $events)
    {
        $this->builder->fire('building');
        $events->fire(new TableIsBuilding($this->builder));

        /**
         * Resolve and set the table model and stream.
         */
        $this->dispatch(new SetTableModel($this->builder));
        $this->dispatch(new SetTableStream($this->builder));
        $this->dispatch(new SetTableOptions($this->builder));
        $this->dispatch(new SetDefaultOptions($this->builder));
        $this->dispatch(new SetTableRepository($this->builder));
        $this->dispatch(new SetDefaultParameters($this->builder));

        /**
         * Before we go any further, authorize the request.
         */
        $this->dispatch(new AuthorizeTable($this->builder));

        /*
         * Build table views and mark active.
         */
        $this->dispatch(new BuildViews($this->builder));
        $this->dispatch(new SetActiveView($this->builder));

        /**
         * Build table filters and flag active.
         */
        $this->dispatch(new BuildFilters($this->builder));
        $this->dispatch(new SetActiveFilters($this->builder));

        /**
         * Build table actions and flag active.
         */
        $this->dispatch(new BuildActions($this->builder));
        $this->dispatch(new SetActiveAction($this->builder));

        /**
         * Build table headers.
         */
        $this->dispatch(new BuildHeaders($this->builder));
        $this->dispatch(new EagerLoadRelations($this->builder));

        /**
         * Get table entries.
         */
        $this->dispatch(new GetTableEntries($this->builder));

        /**
         * Lastly table rows.
         */
        $this->dispatch(new BuildRows($this->builder));

        $this->builder->fire('built');
        $events->fire(new TableWasBuilt($this->builder));
    }
}
