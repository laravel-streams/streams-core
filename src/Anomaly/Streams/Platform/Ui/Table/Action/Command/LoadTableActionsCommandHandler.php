<?php namespace Anomaly\Streams\Platform\Ui\Table\Action\Command;

use Anomaly\Streams\Platform\Ui\Table\Action\ActionFactory;

/**
 * Class LoadTableActionsCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Action\Command
 */
class LoadTableActionsCommandHandler
{

    /**
     * The action factory.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\Action\ActionFactory
     */
    protected $factory;

    /**
     * Create a new LoadTableActionsCommandHandler instance.
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
     * @param LoadTableActionsCommand $command
     */
    public function handle(LoadTableActionsCommand $command)
    {
        $builder = $command->getBuilder();
        $table   = $builder->getTable();
        $actions = $table->getActions();

        foreach ($builder->getActions() as $parameters) {
            $action = $this->factory->make($parameters);

            $action->setPrefix($table->getPrefix());
            $action->setActive(app('request')->has($table->getPrefix() . 'action'));

            $actions->put($action->getSlug(), $action);
        }
    }
}
