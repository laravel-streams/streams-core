<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Action\Command;

/**
 * Class SetActiveActionHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Component\Action\Command
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
