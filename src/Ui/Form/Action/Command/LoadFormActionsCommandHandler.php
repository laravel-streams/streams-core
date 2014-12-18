<?php namespace Anomaly\Streams\Platform\Ui\Form\Action\Command;

use Anomaly\Streams\Platform\Ui\Form\Action\ActionFactory;

/**
 * Class LoadFormActionsCommandHandler
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Form\Action\Command
 */
class LoadFormActionsCommandHandler
{

    /**
     * The action factory.
     *
     * @var \Anomaly\Streams\Platform\Ui\Form\Action\ActionFactory
     */
    protected $factory;

    /**
     * Create a new LoadFormActionsCommandHandler instance.
     *
     * @param ActionFactory $factory
     */
    public function __construct(ActionFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * Handle the command.
     *
     * @param LoadFormActionsCommand $command
     */
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
