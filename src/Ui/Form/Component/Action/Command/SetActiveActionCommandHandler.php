<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Action\Command\Handler;

use Anomaly\Streams\Platform\Ui\Form\Component\Action\Command\SetActiveActionCommand;

/**
 * Class SetActiveActionCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Component\Action\Command
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
        $form    = $builder->getForm();
        $options = $form->getOptions();
        $actions = $form->getActions();

        if ($action = $actions->findBySlug(app('request')->get($options->get('prefix') . 'action'))) {
            $action->setActive(true);
        }

        if (!$action && $action = $actions->first()) {
            $action->setActive(true);
        }
    }
}
