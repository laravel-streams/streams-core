<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Laracasts\Commander\CommanderTrait;

/**
 * Class ModifyQueryCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Command
 */
class ModifyQueryCommandHandler
{

    use CommanderTrait;

    /**
     * Handle the command.
     *
     * @param ModifyQueryCommand $command
     */
    public function handle(ModifyQueryCommand $command)
    {
        $table = $command->getTable();
        $query = $command->getQuery();

        $this->execute(
            'Anomaly\Streams\Platform\Ui\Table\Component\Filter\Command\FilterQueryCommand',
            compact('table', 'query')
        );
        $this->execute(
            'Anomaly\Streams\Platform\Ui\Table\Component\View\Command\TableQueryCommand',
            compact('table', 'query')
        );
    }
}
