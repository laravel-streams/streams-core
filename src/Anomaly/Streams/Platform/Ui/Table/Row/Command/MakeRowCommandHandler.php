<?php namespace Anomaly\Streams\Platform\Ui\Table\Row\Command;

use Anomaly\Streams\Platform\Ui\Table\Row\RowFactory;

class MakeRowCommandHandler
{

    protected $factory;

    function __construct(RowFactory $factory)
    {
        $this->factory = $factory;
    }

    public function handle(MakeRowCommand $command)
    {
        $parameters = [
            'entry'   => $command->getEntry(),
            'buttons' => $command->getButtons(),
            'columns' => $command->getColumns(),
        ];

        return $this->factory->make($parameters);
    }
}
 