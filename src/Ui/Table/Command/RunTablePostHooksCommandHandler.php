<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Laracasts\Commander\CommanderTrait;

/**
 * Class RunTablePostHooksCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Command
 */
class RunTablePostHooksCommandHandler
{

    use CommanderTrait;

    /**
     * Run table post hooks.
     *
     * @param RunTablePostHooksCommand $command
     */
    public function handle(RunTablePostHooksCommand $command)
    {
        $builder = $command->getBuilder();

        $input = compact('builder');

        $this->execute('Anomaly\Streams\Platform\Ui\Table\Action\Command\RunTablePostHookCommand', $input);
    }
}
