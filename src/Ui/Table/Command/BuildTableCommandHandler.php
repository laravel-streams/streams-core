<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Ui\Table\Event\TableDoneEvent;
use Anomaly\Streams\Platform\Ui\Table\Event\TableStartEvent;
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
     * Build the table objects.
     *
     * @param BuildTableCommand $command
     */
    public function handle(BuildTableCommand $command)
    {
        $builder = $command->getBuilder();

        $input = compact('builder');

        // Fire an event to allow hooking into builder configuration.
        app('events')->fire('streams::table.start', new TableStartEvent($builder));

        // Set the streams object on the table if applicable.
        $this->execute('Anomaly\Streams\Platform\Ui\Table\Command\SetTableStreamCommand', $input);

        // Build view object.
        $this->execute('Anomaly\Streams\Platform\Ui\Table\View\Command\BuildTableViewsCommand', $input);
        $this->execute('Anomaly\Streams\Platform\Ui\Table\View\Command\SetActiveViewCommand', $input);

        // Build header objects.
        $this->execute('Anomaly\Streams\Platform\Ui\Table\Header\Command\BuildTableHeadersCommand', $input);

        // Build filters objects.
        $this->execute('Anomaly\Streams\Platform\Ui\Table\Filter\Command\BuildTableFiltersCommand', $input);
        $this->execute('Anomaly\Streams\Platform\Ui\Table\Filter\Command\SetActiveFiltersCommand', $input);

        // Build column objects.
        $this->execute('Anomaly\Streams\Platform\Ui\Table\Column\Command\BuildTableColumnsCommand', $input);

        // Build button objects.
        $this->execute('Anomaly\Streams\Platform\Ui\Table\Button\Command\BuildTableButtonsCommand', $input);

        // Build action objects.
        $this->execute('Anomaly\Streams\Platform\Ui\Table\Action\Command\BuildTableActionsCommand', $input);
        $this->execute('Anomaly\Streams\Platform\Ui\Table\Action\Command\SetActiveActionCommand', $input);

        // Get the table entries.
        $this->execute('Anomaly\Streams\Platform\Ui\Table\Command\GetTableEntriesCommand', $input);

        // Build rows finally.
        $this->execute('Anomaly\Streams\Platform\Ui\Table\Row\Command\BuildTableRowsCommand', $input);

        // Fire an event after everything has finished building.
        app('events')->fire('streams::table.done', new TableDoneEvent($builder));
    }
}
