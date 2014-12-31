<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Laracasts\Commander\CommanderTrait;

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

    use CommanderTrait;

    /**
     * Handle the command.
     *
     * @param HandleTablePostCommand $command
     */
    public function handle(HandleTablePostCommand $command)
    {
        $table = $command->getTable();

        $this->execute(
            'Anomaly\Streams\Platform\Ui\Table\Component\Action\Command\ExecuteActionCommand',
            compact('table')
        );

        dd($command);
    }
}
