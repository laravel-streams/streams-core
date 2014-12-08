<?php namespace Anomaly\Streams\Platform\Ui\Form\Button\Command;

use Anomaly\Streams\Platform\Ui\Form\Button\ButtonFactory;

class MakeButtonCommandHandler
{

    protected $factory;

    function __construct(ButtonFactory $factory)
    {
        $this->factory = $factory;
    }

    public function handle(MakeButtonCommand $command)
    {
        return $this->factory->make($command->getParameters());
    }
}
 