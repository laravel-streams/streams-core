<?php namespace Anomaly\Streams\Platform\Ui\Table\Command\Handler;

use Anomaly\Streams\Platform\Ui\Table\Command\HandleTablePost;
use Anomaly\Streams\Platform\Ui\Table\Component\Action\Command\ExecuteAction;
use Illuminate\Foundation\Bus\DispatchesCommands;

/**
 * Class HandleTablePostHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Command
 */
class HandleTablePostHandler
{

    use DispatchesCommands;

    /**
     * Handle the command.
     *
     * @param HandleTablePost $command
     */
    public function handle(HandleTablePost $command)
    {
        $table = $command->getTable();

        $this->dispatch(new ExecuteAction($table));
    }
}
