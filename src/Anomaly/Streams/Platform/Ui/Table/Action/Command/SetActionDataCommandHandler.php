<?php namespace Anomaly\Streams\Platform\Ui\Table\Action\Command;

use Anomaly\Streams\Platform\Ui\Table\Action\Contract\ActionInterface;

/**
 * Class SetActionDataCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Action\Command
 */
class SetActionDataCommandHandler
{
    /**
     * Handle the command.
     *
     * @param SetActionDataCommand $command
     */
    public function handle(SetActionDataCommand $command)
    {
        $builder = $command->getBuilder();
        $table   = $builder->getTable();

        $actions = [];

        foreach ($table->getActions() as $action) {
            if ($action instanceof ActionInterface) {
                $actions[] = $action->viewData();
            }
        }

        $table->putData('actions', $actions);
    }
}
