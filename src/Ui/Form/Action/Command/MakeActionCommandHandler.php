<?php namespace Anomaly\Streams\Platform\Ui\Form\Action\Command;

use Anomaly\Streams\Platform\Ui\Form\Action\ActionFactory;

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
 