<?php namespace Anomaly\Streams\Platform\Ui\Form\Action\Command;

use Anomaly\Streams\Platform\Ui\Form\Action\ActionFactory;

class LoadFormActionsCommandHandler
{

    protected $factory;

    function __construct(ActionFactory $factory)
    {
        $this->factory = $factory;
    }

    public function handle(LoadFormActionsCommand $command)
    {
        $builder = $command->getBuilder();
        $form    = $builder->getForm();
        $actions = $form->getActions();

        foreach ($builder->getActions() as $parameters) {

            $action = $this->factory->make($parameters);

            $action->setPrefix($form->getPrefix());
            $action->setActive(app('request')->has($form->getPrefix() . 'action'));

            $actions->put($action->getSlug(), $action);
        }
    }
}
 