<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Action\Command;

/**
 * Class SetActiveActionCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Action\Command
 */
class SetActiveActionCommandHandler
{

    /**
     * Set the active action.
     *
     * @param SetActiveActionCommand $command
     */
    public function handle(SetActiveActionCommand $command)
    {
        $builder = $command->getBuilder();
        $table   = $builder->getTable();
        $options = $table->getOptions();
        $actions = $table->getActions();

        if ($action = $actions->findBySlug(app('request')->get($options->get('prefix') . 'action'))) {
            $action->setActive(true);
        }

        if (!$action && $action = $actions->first()) {
            $action->setActive(true);
        }
    }
}
