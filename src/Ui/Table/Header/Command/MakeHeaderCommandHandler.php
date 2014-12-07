<?php namespace Anomaly\Streams\Platform\Ui\Table\Header\Command;

use Anomaly\Streams\Platform\Ui\Table\Header\HeaderFactory;

class MakeHeaderCommandHandler
{

    protected $factory;

    function __construct(HeaderFactory $factory)
    {
        $this->factory = $factory;
    }

    public function handle(MakeHeaderCommand $command)
    {
        return $this->factory->make($command->getParameters());
    }
}
 