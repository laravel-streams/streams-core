<?php namespace Anomaly\Streams\Platform\Ui\Table\Action\Command;

/**
 * Class SetActiveActionCommandHandler
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Action\Command
 */
class SetActiveActionCommandHandler
{

    /**
     * Set the active action
     *
     * @param SetActiveActionCommand $command
     */
    public function handle(SetActiveActionCommand $command)
    {
        $builder = $command->getBuilder();
        $table   = $builder->getTable();
        $actions = $table->getActions();

        $active = app('request')->get($table->getPrefix() . 'view');

        if ($active && $action = $actions->findBySlug($active)) {
            $action->setActive(true);
        }

        if (!$active && $action = $actions->first()) {
            $action->setActive(true);
        }
    }
}
