<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Ui\Table\Component\Action\Command\ExecuteActionCommand;
use Illuminate\Foundation\Bus\DispatchesCommands;

/**
 * Class HandleTablePostCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Command
 */
class HandleTablePostCommandHandler
{

    use DispatchesCommands;

    /**
     * Handle the command.
     *
     * @param HandleTablePostCommand $command
     */
    public function handle(HandleTablePostCommand $command)
    {
        $table = $command->getTable();

        $this->dispatch(new ExecuteActionCommand($table));
    }
}
