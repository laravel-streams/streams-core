<?php namespace Anomaly\Streams\Platform\Ui\Table\Column\Command;

use Anomaly\Streams\Platform\Ui\Table\Column\ColumnFactory;

class MakeColumnCommandHandler
{

    protected $factory;

    function __construct(ColumnFactory $factory)
    {
        $this->factory = $factory;
    }

    public function handle(MakeColumnCommand $command)
    {
        return $this->factory->make($command->getParameters());
    }
}
 