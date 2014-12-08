<?php namespace Anomaly\Streams\Platform\Ui\Form\Action\Command;

class LoadFormActionsCommandHandler
{

    public function handle(LoadFormActionsCommand $command)
    {
        $builder = $command->getBuilder();
        $form    = $builder->getForm();
        $actions = $form->getActions();

        foreach ($builder->getActions() as $parameters) {

            $action = $this->execute(
                'Anomaly\Streams\Platform\Ui\Form\Action\Command\MakeActionCommand',
                compact('parameters')
            );

            $action->setPrefix($form->getPrefix());
            $action->setActive(app('request')->has($form->getPrefix() . 'action'));

            $actions->put($action->getSlug(), $action);
        }
    }
}
 