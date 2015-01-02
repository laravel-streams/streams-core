<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Laracasts\Commander\CommanderTrait;

/**
 * Class LoadTableCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Command
 */
class LoadTableCommandHandler
{

    use CommanderTrait;

    /**
     * Handle the command.
     *
     * @param LoadTableCommand $command
     */
    public function handle(LoadTableCommand $command)
    {
        $table = $command->getTable();

        $data = $table->getData();

        $data->put('table', $table);

        /**
         * Build table pagination.
         */
        $this->execute(
            '\Anomaly\Streams\Platform\Ui\Table\Command\LoadTablePaginationCommand',
            compact('table')
        );
    }
}
