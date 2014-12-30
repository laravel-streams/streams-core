<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Laracasts\Commander\CommanderTrait;

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

    use CommanderTrait;

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
        $this->execute(
            'Anomaly\Streams\Platform\Ui\Table\Command\SetTableModelCommand',
            compact('builder')
        );
        $this->execute(
            'Anomaly\Streams\Platform\Ui\Table\Command\SetTableStreamCommand',
            compact('builder')
        );

        /*
         * Build table views and mark active.
         */
        $this->execute(
            'Anomaly\Streams\Platform\Ui\Table\Component\View\Command\BuildViewsCommand',
            compact('builder')
        );
        $this->execute(
            'Anomaly\Streams\Platform\Ui\Table\Component\View\Command\SetActiveViewCommand',
            compact('builder')
        );

        /**
         * Build table filters and flag active.
         */
        $this->execute(
            'Anomaly\Streams\Platform\Ui\Table\Component\Filter\Command\BuildFiltersCommand',
            compact('builder')
        );
        $this->execute(
            'Anomaly\Streams\Platform\Ui\Table\Component\Filter\Command\SetActiveFiltersCommand',
            compact('builder')
        );

        /**
         * Build table actions and flag active.
         */
        $this->execute(
            'Anomaly\Streams\Platform\Ui\Table\Component\Action\Command\BuildActionsCommand',
            compact('builder')
        );
        $this->execute(
            'Anomaly\Streams\Platform\Ui\Table\Component\Action\Command\SetActiveActionCommand',
            compact('builder')
        );

        /**
         * Build table columns.
         */
        $this->execute(
            'Anomaly\Streams\Platform\Ui\Table\Component\Column\Command\BuildColumnsCommand',
            compact('builder')
        );

        /**
         * Build table buttons.
         */
        $this->execute(
            'Anomaly\Streams\Platform\Ui\Table\Component\Button\Command\BuildButtonsCommand',
            compact('builder')
        );

        /**
         * LAST: Get table entries.
         */
        $this->execute(
            'Anomaly\Streams\Platform\Ui\Table\Command\GetTableEntriesCommand',
            compact('builder')
        );
    }
}
