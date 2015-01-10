<?php namespace Anomaly\Streams\Platform\Ui\Table\Command\Handler;

use Anomaly\Streams\Platform\Ui\Table\Component\Action\Command\BuildActionsCommand;
use Anomaly\Streams\Platform\Ui\Table\Component\Action\Command\SetActiveActionCommand;
use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Command\BuildFiltersCommand;
use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Command\SetActiveFiltersCommand;
use Anomaly\Streams\Platform\Ui\Table\Component\Header\Command\BuildHeadersCommand;
use Anomaly\Streams\Platform\Ui\Table\Component\Row\Command\BuildRowsCommand;
use Anomaly\Streams\Platform\Ui\Table\Component\View\Command\BuildViewsCommand;
use Anomaly\Streams\Platform\Ui\Table\Component\View\Command\SetActiveViewCommand;
use Illuminate\Foundation\Bus\DispatchesCommands;

/**
 * Class BuildTableCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Command
 */
class BuildTableCommandHandler
{

    use DispatchesCommands;

    /**
     * Handle the command.
     *
     * @param BuildTableCommand $command
     */
    public function handle(BuildTableCommand $command)
    {
        $builder = $command->getBuilder();

        /**
         * Resolve and set the table model and stream.
         */
        $this->dispatch(new SetTableModelCommand($builder));
        $this->dispatch(new SetTableStreamCommand($builder));

        /*
         * Build table views and mark active.
         */
        $this->dispatch(new BuildViewsCommand($builder));
        $this->dispatch(new SetActiveViewCommand($builder));

        /**
         * Build table filters and flag active.
         */
        $this->dispatch(new BuildFiltersCommand($builder));
        $this->dispatch(new SetActiveFiltersCommand($builder));

        /**
         * Build table actions and flag active.
         */
        $this->dispatch(new BuildActionsCommand($builder));
        $this->dispatch(new SetActiveActionCommand($builder));

        /**
         * Build table headers.
         */
        $this->dispatch(new BuildHeadersCommand($builder));

        /**
         * Get table entries.
         */
        $this->dispatch(new GetTableEntriesCommand($builder));

        /**
         * Lastly table rows.
         */
        $this->dispatch(new BuildRowsCommand($builder));
    }
}
