<?php namespace Anomaly\Streams\Platform\Ui\Table\Command\Handler;

use Anomaly\Streams\Platform\Ui\Table\Command\BuildTable;
use Anomaly\Streams\Platform\Ui\Table\Command\GetTableEntries;
use Anomaly\Streams\Platform\Ui\Table\Command\SetTableModel;
use Anomaly\Streams\Platform\Ui\Table\Command\SetTableStream;
use Anomaly\Streams\Platform\Ui\Table\Component\Action\Command\BuildActions;
use Anomaly\Streams\Platform\Ui\Table\Component\Action\Command\SetActiveAction;
use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Command\BuildFilters;
use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Command\SetActiveFilters;
use Anomaly\Streams\Platform\Ui\Table\Component\Header\Command\BuildHeaders;
use Anomaly\Streams\Platform\Ui\Table\Component\Row\Command\BuildRows;
use Anomaly\Streams\Platform\Ui\Table\Component\View\Command\BuildViews;
use Anomaly\Streams\Platform\Ui\Table\Component\View\Command\SetActiveView;
use Illuminate\Foundation\Bus\DispatchesCommands;

/**
 * Class BuildTableHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Command
 */
class BuildTableHandler
{

    use DispatchesCommands;

    /**
     * Handle the command.
     *
     * @param BuildTable $command
     */
    public function handle(BuildTable $command)
    {
        $builder = $command->getBuilder();

        /**
         * Resolve and set the table model and stream.
         */
        $this->dispatch(new SetTableModel($builder));
        $this->dispatch(new SetTableStream($builder));

        /*
         * Build table views and mark active.
         */
        $this->dispatch(new BuildViews($builder));
        $this->dispatch(new SetActiveView($builder));

        /**
         * Build table filters and flag active.
         */
        $this->dispatch(new BuildFilters($builder));
        $this->dispatch(new SetActiveFilters($builder));

        /**
         * Build table actions and flag active.
         */
        $this->dispatch(new BuildActions($builder));
        $this->dispatch(new SetActiveAction($builder));

        /**
         * Build table headers.
         */
        $this->dispatch(new BuildHeaders($builder));

        /**
         * Get table entries.
         */
        $this->dispatch(new GetTableEntries($builder));

        /**
         * Lastly table rows.
         */
        $this->dispatch(new BuildRows($builder));
    }
}
