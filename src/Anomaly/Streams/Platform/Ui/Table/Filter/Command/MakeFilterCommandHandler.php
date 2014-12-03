<?php namespace Anomaly\Streams\Platform\Ui\Table\Filter\Command;

use Anomaly\Streams\Platform\Ui\Table\Filter\FilterFactory;

class MakeFilterCommandHandler
{

    protected $factory;

    function __construct(FilterFactory $factory)
    {
        $this->factory = $factory;
    }

    public function handle(MakeFilterCommand $command)
    {
        return $this->factory->make($command->getParameters());
    }
}
 