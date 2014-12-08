<?php namespace Anomaly\Streams\Platform\Ui\Table\Action\Command;

use Anomaly\Streams\Platform\Ui\Table\Action\ActionFactory;

class LoadTableActionsCommandHandler
{

    protected $factory;

    function __construct(ActionFactory $factory)
    {
        $this->factory = $factory;
    }

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
 