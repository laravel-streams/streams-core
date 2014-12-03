<?php namespace Anomaly\Streams\Platform\Ui\Table\View\Command;

use Anomaly\Streams\Platform\Ui\Table\View\ViewFactory;

class MakeViewCommandHandler
{

    protected $factory;

    function __construct(ViewFactory $factory)
    {
        $this->factory = $factory;
    }

    public function handle(MakeViewCommand $command)
    {
        return $this->factory->make($command->getParameters());
    }
}
 