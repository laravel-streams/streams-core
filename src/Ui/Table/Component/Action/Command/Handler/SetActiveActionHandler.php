<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Action\Command\Handler;

use Anomaly\Streams\Platform\Ui\Table\Component\Action\Command\SetActiveAction;

/**
 * Class SetActiveActionHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Action\Command
 */
class SetActiveActionHandler
{

    /**
     * Set the active action.
     *
     * @param SetActiveAction $command
     */
    public function handle(SetActiveAction $command)
    {
        $builder = $command->getBuilder();
        $table   = $builder->getTable();
        $options = $table->getOptions();
        $actions = $table->getActions();

        if ($action = $actions->findBySlug(app('request')->get($options->get('prefix') . 'action'))) {
            $action->setActive(true);
        }
    }
}
