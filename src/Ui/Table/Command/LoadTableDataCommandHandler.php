<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Laracasts\Commander\CommanderTrait;

/**
 * Class LoadTableDataCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Command
 */
class LoadTableDataCommandHandler
{

    use CommanderTrait;

    /**
     * Load all the table data.
     *
     * @param LoadTableDataCommand $command
     */
    public function handle(LoadTableDataCommand $command)
    {
        $builder = $command->getBuilder();

        $input = compact('builder');

        // Load view data.
        $this->execute('Anomaly\Streams\Platform\Ui\Table\View\Command\LoadViewsDataCommand', $input);

        // Load header data.
        $this->execute('Anomaly\Streams\Platform\Ui\Table\Header\Command\LoadHeadersDataCommand', $input);

        // Load filters data.
        $this->execute('Anomaly\Streams\Platform\Ui\Table\Filter\Command\LoadFiltersDataCommand', $input);

        // Load action data.
        $this->execute('Anomaly\Streams\Platform\Ui\Table\Action\Command\LoadActionsDataCommand', $input);

        // Load row data.
        $this->execute('Anomaly\Streams\Platform\Ui\Table\Row\Command\LoadRowDataCommand', $input);

        // Load pagination data.
        $this->execute('Anomaly\Streams\Platform\Ui\Table\Command\LoadPaginationDataCommand', $input);
    }
}
