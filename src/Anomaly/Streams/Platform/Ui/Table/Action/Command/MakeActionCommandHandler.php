<?php namespace Anomaly\Streams\Platform\Ui\Table\Action\Command;

use Anomaly\Streams\Platform\Ui\Table\Action\ActionFactory;

class MakeActionCommandHandler
{

    protected $factory;

    function __construct(ActionFactory $factory)
    {
        $this->factory = $factory;
    }

    public function handle(MakeActionCommand $command)
    {
        return $this->factory->make($command->getParameters());
    }
}
 