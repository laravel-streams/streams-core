<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Ui\Table\Event\TableIsBuilding;
use Anomaly\Streams\Platform\Ui\Table\Event\TableWasBuilt;
use Laracasts\Commander\CommanderTrait;
use Laracasts\Commander\Events\DispatchableTrait;

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
    use DispatchableTrait;

    /**
     * Handle the command.
     *
     * @param BuildTableCommand $command
     */
    public function handle(BuildTableCommand $command)
    {
        $builder = $command->getBuilder();
        $table   = $builder->getTable();

        $table->raise(new TableIsBuilding($builder));

        $this->dispatchEventsFor($table);

        $args = compact('builder');

        $this->execute('Anomaly\Streams\Platform\Ui\Table\View\Command\LoadTableViewsCommand', $args);
        $this->execute('Anomaly\Streams\Platform\Ui\Table\Filter\Command\LoadTableFiltersCommand', $args);
        $this->execute('Anomaly\Streams\Platform\Ui\Table\Column\Command\LoadTableColumnsCommand', $args);
        $this->execute('Anomaly\Streams\Platform\Ui\Table\Header\Command\LoadTableHeadersCommand', $args);
        $this->execute('Anomaly\Streams\Platform\Ui\Table\Button\Command\LoadTableButtonsCommand', $args);
        $this->execute('Anomaly\Streams\Platform\Ui\Table\Action\Command\LoadTableActionsCommand', $args);
        $this->execute('Anomaly\Streams\Platform\Ui\Table\Command\LoadTableEntriesCommand', $args);

        $table->raise(new TableWasBuilt($builder));

        $this->dispatchEventsFor($table);

        $this->execute('Anomaly\Streams\Platform\Ui\Table\Row\Command\LoadTableRowsCommand', $args);
    }
}
